<?php

namespace App\Api;

class SpecificationConcrete implements Specification
{
    public function getTitle(): string
    {
        return '';
    }

    public function getDescription(): string
    {
        return '';
    }

    public function getVersion(): string
    {
        return '';
    }

    public function getPaths(): Paths
    {
        return new Paths();
    }

    public function getDefinitions(): array
    {
        return [];
    }

    public function getTags(): array
    {
        return [];
    }
}
