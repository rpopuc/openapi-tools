<?php

namespace App\Api;

use App\Api\Paths;

interface Specification
{
    public function getTitle(): string;
    public function getDescription(): string;
    public function getVersion(): string;
    public function getPaths(): Paths;
    public function getDefinitions(): array;
    public function getTags(): array;
}
