<?php

namespace Tests\Validators\Stubs;

use App\Api\Schemas as SchemasConcrete;

class Schemas extends SchemasConcrete
{
    public function __construct(array $data)
    {
        foreach ($data as $schemaData) {
            $this->add(new Schema($schemaData));
        }
    }
}
