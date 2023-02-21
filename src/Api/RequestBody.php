<?php

namespace App\Api;

interface RequestBody
{
    public function getDescription(): string;
    public function getContent(): MediaTypes;
    public function isRequired(): bool;
}
