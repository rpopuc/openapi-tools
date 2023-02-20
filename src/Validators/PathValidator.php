<?php

namespace App\Validators;

use App\Api\Path;
use App\Api\Specification;

class PathValidator
{
    public function validate(Specification $provider, Specification $consumer, Path $path): array
    {
        $summary = [];
        if (!$providerPath = $this->findPathByEndpoint($path->getEndpoint(), $provider)) {
            $summary[] = "Endpoint does not exists: {$path->getEndpoint()}";
        }

        return $summary;
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
}
