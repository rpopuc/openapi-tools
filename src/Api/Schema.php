<?php

namespace App\Api;

interface Schema
{
    public function getTitle(): string;
    public function getType(): string;
    public function getMultipleOf(): float;
    public function getMaximum(): float;
    public function isExclusiveMaximum(): bool;
    public function getMinimum(): float;
    public function isExclusiveMinimum(): bool;
    public function getMaxLength(): int;
    public function getMinLength(): int;
    public function getPattern(): string;
    public function getMaxItems(): int;
    public function getMinItems(): int;
    public function isUniqueItems(): bool;
    public function maxProperties(): int;
    public function minProperties(): int;
    public function getRequired(): array;
    public function getEnum(): array;
        // The following properties are taken from the JSON Schema definition but their definitions were adjusted to the OpenAPI Specification.
    public function getAllOf(): array;
    public function getOneOf(): array;
    public function getAnyOf(): array;
    public function getNot(): Schema;
    public function getItems(): Schema;
    public function getProperties(): array;
    public function getDescription(): string;
    public function getFormat(): string;
    public function getDefault(): string;
    public function isNullable(): bool;
    // 'discriminator' => Discriminator::class,
    public function isReadOnly(): bool;
    public function isWriteOnly(): bool;
    // 'xml' => Xml::class,
    // 'externalDocs' => ExternalDocumentation::class,
    public function getExample(): string;
    public function isDeprecated(): bool;
}
