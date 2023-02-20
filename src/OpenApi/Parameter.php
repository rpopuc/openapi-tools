<?php

namespace App\OpenApi;

use App\Api\Parameter as ParameterInterface;
use App\Api\Specification;
use cebe\openapi\spec\Example;
use cebe\openapi\spec\MediaType;
use cebe\openapi\spec\Parameter as ParameterSpecification;
use cebe\openapi\spec\Schema;
use cebe\openapi\spec\Type;

class Parameter implements ParameterInterface
{
    private ParameterSpecification $specification;
    private string $name;
    private string $in;
    private string $description;
    private bool $required;
    private bool $deprecated;
    private bool $allowEmptyValue;
    private string $style;
    private bool $explode;
    private string $allowReserved;
    private string $schema;
    private string $example;
    private string $examples;
    private string $content;

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

    public function getSchema(): ?string
    {
        return null;
        // return $this->definition->schema;
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
