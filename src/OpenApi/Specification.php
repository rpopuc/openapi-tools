<?php

namespace App\OpenApi;

use App\Api\Paths;
use App\Api\Specification as SpectificationInterface;
use cebe\openapi\SpecObjectInterface;

class Specification implements SpectificationInterface
{
    private SpecObjectInterface $specification;

    public function __construct(SpecObjectInterface $spectificationObject)
    {
        $this->specification = $spectificationObject;
    }

    public function getTitle(): string
    {
        return $this->specification->info->title ?? '';
    }

    public function getDescription(): string
    {
        return $this->specification->info->description ?? '';
    }

    public function getVersion(): string
    {
        return $this->specification->info->version ?? '';
    }

    public function getPaths(): Paths
    {
        $paths = new Paths;
        foreach ($this->specification->paths as $path => $definition) {
            $paths->add(new Path($path, $definition));
        }

        return $paths;
    }

    public function getDefinitions(): array
    {
        $definitions = [];
        foreach ($this->specification->definitions as $definition) {
            $definitions[] = $definition;
        }

        return $definitions;
    }

    public function getTags(): array
    {
        $tags = [];
        foreach ($this->specification->tags as $tag) {
            $tags[] = $tag;
        }

        return $tags;
    }
}
