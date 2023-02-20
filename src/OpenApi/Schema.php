<?php

namespace App\OpenApi;

use App\Api\Schema as SchemaInterface;
use cebe\openapi\spec\Schema as SchemaSpecification;

class Schema implements SchemaInterface
{
    private SchemaSpecification $definition;

    public function __construct(SchemaSpecification $definition)
    {
        $this->definition = $definition;
    }

    public function getTitle(): string
    {
        return $this->definition->title;
    }

    public function getType(): string
    {
        return $this->definition->type;
    }

    public function getMultipleOf(): float
    {
        return $this->definition->multipleOf;
    }

    public function getMaximum(): float
    {
        return $this->definition->maximum;
    }

    public function isExclusiveMaximum(): bool
    {
        return $this->definition->exclusiveMaximum;
    }

    public function getMinimum(): float
    {
        return $this->definition->minimum;
    }

    public function isExclusiveMinimum(): bool
    {
        return $this->definition->exclusiveMinimum;
    }

    public function getMaxLength(): int
    {
        return $this->definition->maxLength;
    }

    public function getMinLength(): int
    {
        return $this->definition->minLength;
    }

    public function getPattern(): string
    {
        return $this->definition->pattern;
    }

    public function getMaxItems(): int
    {
        return $this->definition->maxItems;
    }

    public function getMinItems(): int
    {
        return $this->definition->minItems;
    }

    public function isUniqueItems(): bool
    {
        return $this->definition->uniqueItems;
    }

    public function maxProperties(): int
    {
        return $this->definition->maxProperties;
    }

    public function minProperties(): int
    {
        return $this->definition->minProperties;
    }

    public function getRequired(): array
    {
        return $this->definition->required;
    }

    public function getEnum(): array
    {
        return $this->definition->enum;
    }

    public function getAllOf(): array
    {
        return $this->definition->allOf;
    }

    public function getOneOf(): array
    {
        return $this->definition->oneOf;
    }

    public function getAnyOf(): array
    {
        return $this->definition->anyOf;
    }

    public function getNot(): SchemaInterface
    {
        return new Schema($this->definition->not);
    }

    public function getItems(): SchemaInterface
    {
        return new Schema($this->definition->items);
    }

    public function getProperties(): array
    {
        return $this->definition->properties;
    }

    public function getDescription(): string
    {
        return $this->definition->description;
    }

    public function getFormat(): string
    {
        return $this->definition->format;
    }

    public function getDefault(): string
    {
        return $this->definition->default;
    }

    public function isNullable(): bool
    {
        return $this->definition->nullable;
    }

    public function isReadOnly(): bool
    {
        return $this->definition->readOnly;
    }

    public function isWriteOnly(): bool
    {
        return $this->definition->writeOnly;
    }

    public function getExample(): string
    {
        return $this->definition->example;
    }

    public function isDeprecated(): bool
    {
        return $this->definition->deprecated;
    }
}
