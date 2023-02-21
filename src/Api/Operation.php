<?php

namespace App\Api;

interface Operation extends SpecificationItem
{
    public function getMethod(): string;
    public function getSummary(): ?string;
    public function getDescription(): ?string;
    public function getParameters(): Parameters;
    public function getRequestBody(): ?RequestBody;
}
