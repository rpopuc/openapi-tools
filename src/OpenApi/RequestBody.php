<?php

namespace App\OpenApi;

use App\Api\MediaTypes;
use App\Api\RequestBody as RequestBodyInterface;
use cebe\openapi\spec\RequestBody as RequestBodySpecification;

class RequestBody implements RequestBodyInterface
{
    private RequestBodySpecification $specification;

    public function __construct(RequestBodySpecification $specification)
    {
        $this->specification = $specification;
    }

    public function getDescription(): string
    {
        return $this->specification->description;
    }

    public function getContent(): MediaTypes
    {
        $result = new MediaTypes();

        foreach ($this->specification->content as $type => $mediaTypeSpecification) {
            $result->add(new MediaType($type, $mediaTypeSpecification));
        }

        return $result;
    }

    public function isRequired(): bool
    {
        return $this->specification->required;
    }
}
