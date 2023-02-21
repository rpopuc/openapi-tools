<?php

namespace App\Api;

interface MediaType extends SpecificationItem
{
    public function getType(): string;
    public function getSchema(): Schema;
    public function getExample(): string;
    public function getExamples(): array;
    public function getEncoding(): array;
}
