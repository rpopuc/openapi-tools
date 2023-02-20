<?php

namespace App\Api;

interface Path extends SpecificationItem
{
    public function getEndpoint(): string;
    public function getMethod(): string;
    public function getSummary(): ?string;
    public function getDescription(): ?string;
    public function getOperationId(): string;
    // public function getProduces(): Produces;
    // public function getConsumes(): Consumes;
    // public function getParameters(): Parameters;
    // public function getResponses(): Responses;
    // public function getTags(): Tags;

}
