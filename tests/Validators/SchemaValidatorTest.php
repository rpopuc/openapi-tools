<?php

use App\Validators\SchemaValidator;
use Tests\Validators\Stubs\Schema as SchemaStub;
use Tests\Validators\Stubs\Schemas as SchemasStub;

test('Validates array of simple type', function () {
    $providerSchema = new SchemaStub([
        'type' => 'array',
        'items' => new SchemaStub([
            'type' => 'string'
        ])
    ]);

    $consumerSchema = new SchemaStub([
        'type' => 'array',
        'items' => new SchemaStub([
            'type' => 'string'
        ])
    ]);

    $validator = new SchemaValidator;
    $summary = $validator->validate($providerSchema, $consumerSchema);

    expect($summary->isValid())->toBeTrue();
});

test('Validates object type', function () {
    $providerSchema = new SchemaStub([
        'type' => 'object',
        'properties' => new SchemasStub([
            [
                'name' => 'name',
                'type' => 'string',
            ],
            [
                'name' => 'age',
                'type' => 'number'
            ]
        ])
    ]);

    $consumerSchema = new SchemaStub([
        'type' => 'object',
        'properties' => new SchemasStub([
            [
                'name' => 'name',
                'type' => 'string',
            ],
            [
                'name' => 'age',
                'type' => 'number'
            ]
        ])
    ]);

    $validator = new SchemaValidator;
    $summary = $validator->validate($providerSchema, $consumerSchema);

    expect($summary->isValid())->toBeTrue();
});

test('Validates array of object type', function () {
    $providerSchema = new SchemaStub([
        'type' => 'array',
        'items' => new SchemaStub([
            'type' => 'object',
            'properties' => new SchemasStub([
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'age',
                    'type' => 'number'
                ]
            ])
        ])
    ]);

    $consumerSchema = new SchemaStub([
        'type' => 'array',
        'items' => new SchemaStub([
            'type' => 'object',
            'properties' => new SchemasStub([
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'age',
                    'type' => 'number'
                ]
            ])
        ])
    ]);

    $validator = new SchemaValidator;
    $summary = $validator->validate($providerSchema, $consumerSchema);

    expect($summary->isValid())->toBeTrue();
});

test('Validates array of nested object type', function () {
    $providerSchema = new SchemaStub([
        'type' => 'array',
        'items' => new SchemaStub([
            'type' => 'object',
            'properties' => new SchemasStub([
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'address',
                    'type' => 'object',
                    'properties' => new SchemasStub([
                        [
                            'name' => 'street',
                            'type' => 'string',
                        ],
                        [
                            'name' => 'number',
                            'type' => 'string',
                        ],
                    ])
                ]
            ])
        ])
    ]);

    $consumerSchema = new SchemaStub([
        'type' => 'array',
        'items' => new SchemaStub([
            'type' => 'object',
            'properties' => new SchemasStub([
                [
                    'name' => 'name',
                    'type' => 'string',
                ],
                [
                    'name' => 'address',
                    'type' => 'object',
                    'properties' => new SchemasStub([
                        [
                            'name' => 'street',
                            'type' => 'string',
                        ],
                        [
                            'name' => 'number',
                            'type' => 'string',
                        ],
                    ])
                ]
            ])
        ])
    ]);

    $validator = new SchemaValidator;
    $summary = $validator->validate($providerSchema, $consumerSchema);

    expect($summary->isValid())->toBeTrue();
});
