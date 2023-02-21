<?php

namespace Tests\Validators\Stubs;

use App\Api\Schema as SchemaInterface;
use App\Api\Schemas;

class Schema implements SchemaInterface
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getName(): string
    {
        return $this->data['name'] ?? '';
    }

    public function getTitle(): ?string
    {
        return $this->data['title'] ?? null;
    }

    public function getType(): string
    {
        return $this->data['type'] ?? '';
    }

    public function getMultipleOf(): float
    {
        return 0;
    }

    public function getMaximum(): float
    {
        return 0;
    }

    public function isExclusiveMaximum(): bool
    {
        return false;
    }

    public function getMinimum(): float
    {
        return 0;
    }

    public function isExclusiveMinimum(): bool
    {
        return false;
    }

    public function getMaxLength(): int
    {
        return false;
    }

    public function getMinLength(): int
    {
        return 0;
    }

    public function getPattern(): string
    {
        return '';
    }

    public function getMaxItems(): int
    {
        return 0;
    }

    public function getMinItems(): int
    {
        return 0;
    }

    public function isUniqueItems(): bool
    {
        return false;
    }

    public function maxProperties(): int
    {
        return 0;
    }

    public function minProperties(): int
    {
        return 0;
    }

    public function getRequired(): array
    {
        return [];
    }

    public function getEnum(): array
    {
        return [];
    }

    public function getAllOf(): array
    {
        return [];
    }

    public function getOneOf(): array
    {
        return [];
    }

    public function getAnyOf(): array
    {
        return [];
    }

    public function getNot(): SchemaInterface
    {
        return $this->data['not'];
    }

    public function getItems(): SchemaInterface
    {
        return $this->data['items'];
    }

    public function getProperties(): Schemas
    {
        return $this->data['properties'];
    }

    public function getDescription(): string
    {
        return $this->data['description'] ?? '';
    }

    public function getFormat(): ?string
    {
        return $this->data['format'] ?? null;
    }

    public function getDefault(): string
    {
        return $this->data['default'] ?? '';
    }

    public function isNullable(): bool
    {
        return $this->data['nullable'];
    }

    public function isReadOnly(): bool
    {
        return $this->data['readOnly'];
    }

    public function isWriteOnly(): bool
    {
        return $this->data['writeOnly'];
    }

    public function getExample(): string
    {
        return $this->data['example'] ?? '';
    }

    public function isDeprecated(): bool
    {
        return $this->data['deprecated'];
    }
}
