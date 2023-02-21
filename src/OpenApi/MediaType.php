<?php

namespace App\OpenApi;

use App\Api\MediaType as MediaTypeInterface;
use App\Api\Schema as SchemaInterface;
use cebe\openapi\spec\MediaType as MediaTypeSpecification;

class MediaType implements MediaTypeInterface
{
    private MediaTypeSpecification $specification;
    private string $type;

    public function __construct(string $type, MediaTypeSpecification $specification)
    {
        $this->type = $type;
        $this->specification = $specification;
    }

    public function getSchema(): SchemaInterface
    {
        return new Schema($this->specification->schema);
    }

    public function getExample(): string
    {
        return $this->specification->example;
    }

    public function getExamples(): array
    {
        return $this->specification->examples;
    }

    public function getEncoding(): array
    {
        return $this->specification->encoding;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
