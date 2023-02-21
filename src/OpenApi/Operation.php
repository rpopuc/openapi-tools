<?php

namespace App\OpenApi;

use App\Api\Operation as OperationInterface;
use App\Api\Parameters;
use App\Api\RequestBody as RequestBodyInterface;
use cebe\openapi\spec\Operation as OperationDefinition;

class Operation implements OperationInterface
{
    private OperationDefinition $definition;
    private string $method;

    public function __construct(string $method, OperationDefinition $definition)
    {
        $this->method = $method;
        $this->definition = $definition;
    }

    public function getSummary(): ?string
    {
        return $this->definition->summary;
    }

    public function getDescription(): ?string
    {
        return $this->definition->description;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParameters(): Parameters
    {
        $result = new Parameters();

        foreach ($this->definition->parameters as $definition) {
            $result->add(new Parameter($definition));
        }

        return $result;
    }

    public function getRequestBody(): ?RequestBodyInterface
    {
        if (!$this->definition->requestBody) {
            return null;
        }

        return new RequestBody($this->definition->requestBody);
    }
}
