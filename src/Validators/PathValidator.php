<?php

namespace App\Validators;

use App\Api\Path;
use App\Api\Specification;

class PathValidator
{
    public function validate(Specification $provider, Specification $consumer, Path $path): Summary
    {
        $summary = new Summary;

        if (!$providerPath = $this->findPathByEndpoint($path->getEndpoint(), $provider)) {
            return $summary->addError("Endpoint does not exists: {$path->getEndpoint()}");
        }

        return $summary->merge($this->validateQueryParametersTypes($path, $providerPath))
            //->merge($this->validateRequiredParameters($path, $providerPath))
            ->merge($this->validateOperations($path, $providerPath));
    }

    private function findPathByEndpoint(string $endpoint, Specification $provider): ?Path
    {
        $normalizer = new EndpointNormalizer();
        $endpoint = $normalizer->normalize($endpoint);
        foreach ($provider->getPaths() as $path) {
            $providerEndpoint = $normalizer->normalize($path->getEndpoint());
            if ($providerEndpoint === $endpoint) {
                return $path;
            }
        }

        return null;
    }

    private function validateQueryParametersTypes(Path $path, Path $providerPath): Summary
    {
        $summary = new Summary();
        $parameters = $path->getParameters();
        $providerParameters = $providerPath->getParameters();
        foreach ($parameters as $order => $parameter) {
            $providerParameter = $providerParameters[$order];
            $schemaValidator = new SchemaValidator;
            $summary->merge($schemaValidator->validate(
                providerSchema: $providerParameter->getSchema(),
                consumerSchema: $parameter->getSchema(),
            ), "Parameter {$parameter->getName()}: ");
        }

        return $summary;
    }

    private function validateOperations(Path $path, Path $providerPath): Summary
    {
        $summary = new Summary();
        foreach ($path->getOperations() as $operation) {
            if (!$providerPath->getOperation($operation->getMethod())) {
                $summary->addError("There are no operation '{$operation->getMethod()}' for endpoint '{$path->getEndpoint()}'");
            }
        }

        return $summary;
    }
}
