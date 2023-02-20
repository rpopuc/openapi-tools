<?php

namespace App\OpenApi;

use App\Api\Parameter as ParameterInterface;
use cebe\openapi\spec\Parameter as ParameterSpecification;

class Parameter implements ParameterInterface
{
    private ParameterSpecification $specification;

    public function __construct(ParameterSpecification $specification)
    {
        $this->specification = $specification;
    }

    public function getName(): string
    {
        return $this->specification->name;
    }

    public function getIn(): string
    {
        return $this->specification->in;
    }

    public function getDescription(): string
    {
        return $this->specification->description;
    }

    public function isRequired(): bool
    {
        return $this->specification->required;
    }

    public function isDeprecated(): bool
    {
        return $this->specification->deprecated;
    }

    public function isAllowEmptyValue(): bool
    {
        return $this->specification->allowEmptyValue;
    }

    public function getStyle(): string
    {
        return $this->specification->style;
    }

    public function isExplode(): bool
    {
        return $this->specification->explode;
    }

    public function getAllowReserved(): string
    {
        return $this->specification->allowReserved;
    }

    public function getSchema(): Schema
    {
        return new Schema($this->specification->schema);
    }

    public function getExample(): string
    {
        return $this->specification->example;
    }

    public function getExamples(): string
    {
        return implode("\n", $this->specification->examples);
    }

    public function getContent(): ?string
    {
        return null;
        // return $this->definition->content;
    }
}
