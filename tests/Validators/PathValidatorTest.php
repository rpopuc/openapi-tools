<?php

use App\Api\Operations;
use App\Api\Parameter;
use App\Api\Parameters;
use App\Api\Path;
use App\Api\Paths;
use App\Api\Schema;
use App\Api\Specification;
use App\Validators\PathValidator;
use Tests\Validators\Stubs\Schema as SchemaStub;

test('Validates path', function () {
    $provider = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/v1',
                getParameters: fn() => new Parameters()
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
                getOperations: fn() => new Operations(),
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
                getOperations: fn() => new Operations(),
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
                getOperations: fn() => new Operations(),
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
                    $parameters->add(mock(Parameter::class)->expect(
                        getSchema: fn() => mock(Schema::class)->expect(
                            getType: fn() => 'string'
                        )
                    ));
                    $parameters->add(mock(Parameter::class)->expect(
                        getSchema: fn() => mock(Schema::class)->expect(
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
                    $parameters->add(mock(Parameter::class)->expect(
                        getName: fn() => 'first',
                        getSchema: fn() => mock(Schema::class)->expect(
                            getType: fn() => 'string'
                        )
                    ));
                    $parameters->add(mock(Parameter::class)->expect(
                        getName: fn() => 'second',
                        getSchema: fn() => mock(Schema::class)->expect(
                            getType: fn() => 'number'
                        )
                    ));
                    return $parameters;
                },
                getOperations: fn() => new Operations(),
            ));
            return $paths;
        },
    );

    $validator = new PathValidator();
    $result = $validator->validate(
        provider: $provider,
        consumer: $consumer,
        path: $consumer->getPaths()[0]
    );

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
                    $parameters->add(mock(Parameter::class)->expect(
                        getSchema: fn() => mock(Schema::class)->expect(
                            getType: fn() => 'string'
                        )
                    ));
                    $parameters->add(mock(Parameter::class)->expect(
                        getSchema: fn() => mock(Schema::class)->expect(
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
                getOperations: fn() => new Operations(),
                getParameters: function() {
                    $parameters = new Parameters;
                    $parameters->add(mock(Parameter::class)->expect(
                        getName: fn() => 'id',
                        getSchema: fn() => mock(Schema::class)->expect(
                            getType: fn() => 'number'
                        )
                    ));
                    $parameters->add(mock(Parameter::class)->expect(
                        getName: fn() => 'action',
                        getSchema: fn() => mock(Schema::class)->expect(
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
            "Parameter id: expected type 'string', not 'number'",
            "Parameter action: expected type 'number', not 'string'"
        ]);
});

test('Validates operations', function () {
    $provider = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/v1',
                getOperation: function($method) {
                    try {
                        $specification = new \cebe\openapi\spec\Operation([]);
                    } catch (\cebe\openapi\exceptions\TypeErrorException $e) {
                    }
                    return new \App\OpenApi\Operation($method, $specification);
                },
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
                getOperations: function() {
                    $operations = new Operations();
                    $operations->add(mock(\App\Api\Operation::class)->expect(
                        getMethod: fn() => 'post',
                    ));
                    $operations->add(mock(\App\Api\Operation::class)->expect(
                        getMethod: fn() => 'get',
                    ));
                    return $operations;
                },
                getParameters: fn() => new Parameters(),
            ));
            return $paths;
        },
    );

    $validator = new PathValidator();
    $result = $validator->validate($provider, $consumer, $consumer->getPaths()[0]);

    expect($result->isValid())->toBeTrue();
});

test('Verifies invalid operation', function () {
    $provider = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/v1',
                getOperation: function($method) {
                    return null;
                },
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
                getOperations: function() {
                    $operations = new Operations();
                    $operations->add(mock(\App\Api\Operation::class)->expect(
                        getMethod: fn() => 'post',
                    ));
                    $operations->add(mock(\App\Api\Operation::class)->expect(
                        getMethod: fn() => 'get',
                    ));
                    return $operations;
                },
                getParameters: fn() => new Parameters(),
            ));
            return $paths;
        },
    );

    $validator = new PathValidator();
    $result = $validator->validate($provider, $consumer, $consumer->getPaths()[0]);

    expect($result->isValid())->toBeFalse()
        ->and($result->getErrors())->toHaveCount(2)
        ->and($result->getErrors())->toBe([
            "There are no operation 'post' for endpoint '/api/v1'",
            "There are no operation 'get' for endpoint '/api/v1'",
        ]);
});

test('Verifies required parameters', function () {
    $provider = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/v1',
                getParameters: function() {
                    $parameters = new Parameters;
                    $parameters->add(mock(Parameter::class)->expect(
                        getSchema: fn() => mock(Schema::class)->expect(
                            getType: fn() => 'string'
                        ),
                        isRequired: fn() => true,
                    ));
                    return $parameters;
                },
            ));
            return $paths;
        },
    );

    $consumer = mock(Specification::class)->expect(
        getPaths: function() {
            $paths = new Paths;
            $paths->add(mock(Path::class)->expect(
                getEndpoint: fn() => '/api/v1',
                getOperations: fn() => new Operations(),
                getParameters: function() {
                    $parameters = new Parameters;
                    $parameters->add(mock(Parameter::class)->expect(
                        getName: fn() => 'filter',
                        getSchema: fn() => new SchemaStub([
                            'type' => 'string'
                        ]),
                    ));
                    return $parameters;
                },
            ));
            return $paths;
        },
    );

    $validator = new PathValidator();
    $result = $validator->validate($provider, $consumer, $consumer->getPaths()[0]);

    expect($result->isValid())->toBeTrue();
});
