<?php

use App\Api\Parameters;
use App\Api\Path;
use App\Api\Paths;
use App\Api\Specification;
use App\Validators\PathValidator;

test('Validates path', function () {
    $provider = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/v1',
                getParameters: fn() => new Parameters(),
            ));
            return $paths;
        },
    );

    $consumer = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths();
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/v1',
                getParameters: fn() => new Parameters(),
            ));
            return $paths;
        },
    );

    $validator = new PathValidator();
    $result = $validator->validate($provider, $consumer, $consumer->getPaths()[0]);

    expect($result->isValid())->toBeTrue();
});

test('Throws an error when endpoint does not exist', function () {
    $provider = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/v1/action',
            ));
            return $paths;
        },
    );

    $consumer = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths();
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/action',
            ));
            return $paths;
        },
    );

    $validator = new PathValidator();
    $result = $validator->validate($provider, $consumer, $consumer->getPaths()[0]);

    expect($result->isValid())->toBeFalse()
        ->and($result->getErrors()[0])->toBe("Endpoint does not exists: /action");
});

test('Validates one parameter with different names', function () {
    $provider = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/{parameter}/v1',
                getParameters: fn() => new Parameters(),
            ));
            return $paths;
        },
    );

    $consumer = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths();
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/{id}/v1',
                getParameters: fn() => new Parameters(),
            ));
            return $paths;
        },
    );

    $validator = new PathValidator();
    $result = $validator->validate($provider, $consumer, $consumer->getPaths()[0]);

    expect($result->isValid())->toBeTrue();
});

test('Validates multiple parameters with different names', function () {
    $provider = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/{first}/v1/{second}/',
                getParameters: fn() => new Parameters(),
            ));
            return $paths;
        },
    );

    $consumer = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths();
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/{id}/v1/{param}',
                getParameters: fn() => new Parameters(),
            ));
            return $paths;
        },
    );

    $validator = new PathValidator();
    $result = $validator->validate($provider, $consumer, $consumer->getPaths()[0]);

    expect($result->isValid())->toBeTrue();
});

test("Validates parameter's types", function () {
    $provider = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/{first}/v1/{second}/',
                getParameters: function() {
                    $parameters = new Parameters;
                    $parameters->add(mock(\App\Api\Parameter::class)->expect(
                        getSchema: fn() => mock(\App\Api\Schema::class)->expect(
                            getType: fn() => 'string'
                        )
                    ));
                    $parameters->add(mock(\App\Api\Parameter::class)->expect(
                        getSchema: fn() => mock(\App\Api\Schema::class)->expect(
                            getType: fn() => 'number'
                        )
                    ));
                    return $parameters;
                }
            ));
            return $paths;
        },
    );

    $validator = new PathValidator();
    $result = $validator->validate($provider, $provider, $provider->getPaths()[0]);

    expect($result->isValid())->toBeTrue();
});

test("Verifies invalid parameter's types", function () {
    $provider = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/{first}/v1/{second}/',
                getParameters: function() {
                    $parameters = new Parameters;
                    $parameters->add(mock(\App\Api\Parameter::class)->expect(
                        getSchema: fn() => mock(\App\Api\Schema::class)->expect(
                            getType: fn() => 'string'
                        )
                    ));
                    $parameters->add(mock(\App\Api\Parameter::class)->expect(
                        getSchema: fn() => mock(\App\Api\Schema::class)->expect(
                            getType: fn() => 'number'
                        )
                    ));
                    return $parameters;
                }
            ));
            return $paths;
        },
    );

    $consumer = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/{first}/v1/{second}/',
                getParameters: function() {
                    $parameters = new Parameters;
                    $parameters->add(mock(\App\Api\Parameter::class)->expect(
                        getName: fn() => 'id',
                        getSchema: fn() => mock(\App\Api\Schema::class)->expect(
                            getType: fn() => 'number'
                        )
                    ));
                    $parameters->add(mock(\App\Api\Parameter::class)->expect(
                        getName: fn() => 'action',
                        getSchema: fn() => mock(\App\Api\Schema::class)->expect(
                            getType: fn() => 'string'
                        )
                    ));
                    return $parameters;
                }
            ));
            return $paths;
        },
    );

    $validator = new PathValidator();
    $result = $validator->validate($provider, $consumer, $consumer->getPaths()[0]);

    expect($result->isValid())->toBeFalse()
        ->and($result->getErrors())->toHaveCount(2)
        ->and($result->getErrors())->toBe([
            "Parameter id expected to be from type 'string', not 'number'",
            "Parameter action expected to be from type 'number', not 'string'"
        ]);
});