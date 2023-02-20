<?php

namespace App\OpenApi;

use App\Api\Operations;
use App\Api\Parameters;
use Exception;
use App\Api\Path as PathInterface;
use App\Api\Specification;
use cebe\openapi\spec\PathItem;
use cebe\openapi\spec\Paths;

class Path implements PathInterface
{
    private string $endpoint;
    private PathItem $definition;

    public function __construct(string $endpoint, PathItem $definition)
    {
        $this->endpoint = $endpoint;
        $this->definition = $definition;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getSummary(): ?string
    {
        return $this->definition->summary;
    }

    public function getDescription(): ?string
    {
        return $this->definition->description;
    }

    public function getOperationId(): string
    {
        return $this->definition->operationId;
    }

    public function getParameters(): Parameters
    {
        $result = new Parameters();

        foreach ($this->definition->parameters as $definition) {
            $result->add(new Parameter($definition));
        }

        return $result;
    }

    public function getOperations(): Operations
    {
        $result = new Operations;

        foreach ($this->definition->getOperations() as $method => $definition) {
            $result->add(new Operation($method, $definition));
        }

        return $result;
    }

    public function getOperation(string $method): ?Operation
    {
        $operations = $this->getOperations();
        foreach ($operations as $operation) {
            if ($operation->getMethod() === $method) {
                return $operation;
            }
        }

        return null;
    }

    public function setParameters(Parameters $parameters): void
    {
        $this->parameters = $parameters;
    }

    public function getProduces(): Produces
    {
        return $this->produces;
    }

    public function setProduces(Produces $produces): void
    {
        $this->produces = $produces;
    }

    public function getConsumes(): Consumes
    {
        return $this->consumes;
    }

    public function setConsumes(Consumes $consumes): void
    {
        $this->consumes = $consumes;
    }

    public function getResponses(): Responses
    {
        return $this->responses;
    }

    public function setResponses(Responses $responses): void
    {
        $this->responses = $responses;
    }

    public function getUri(): string
    {
        return preg_replace('/{.*}/', '{param}', $this->getEndpoint());
    }

    /**
     * @throws Exception
     */
    public function getPathParameters(): Parameters
    {
        $parameters = new Parameters();

        if (preg_match_all('/{(.*?)}/', $this->getEndpoint(), $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $parameterName = $match[1];
                $parameter = $this->parameters->findByName($parameterName);
                if (!$parameter) {
                    throw new Exception("Parameter '$parameterName' not defined");
                }
                $parameters->add($parameter);
            }
        }

        return $parameters;
    }

    public function getBodyParameters(): Parameters
    {
        return $this->parameters->filter(function (Parameter $parameter) {
            return Parameter::IN_BODY == $parameter->getIn();
        });
    }

    public function getFormDataParameters(): Parameters
    {
        return $this->parameters->filter(function (Parameter $parameter) {
            return Parameter::IN_FORM_DATA == $parameter->getIn();
        });
    }

    public function getQueryParameters(): Parameters
    {
        return $this->parameters->filter(function (Parameter $parameter) {
            return Parameter::IN_QUERY == $parameter->getIn();
        });
    }

    public function getRequiredParameters(): Parameters
    {
        return $this->parameters->filter(function (Parameter $parameter) {
            return $parameter->isRequired()
                && Parameter::IN_PATH !== $parameter->getIn();
        });
    }

    public function getTags(): Tags
    {
        return $this->tags;
    }

    public function setTags(Tags $tags): void
    {
        $this->tags = $tags;
    }

    public function getResponsesStatus(): Collection
    {
        return $this->getResponses()->pluck('code');
    }
}
