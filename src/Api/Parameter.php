<?php

namespace App\Api;

interface Parameter extends SpecificationItem
{
    public function getName(): string;
    public function getDescription(): string;
    public function getIn(): string;
    public function getSchema(): Schema;
}
