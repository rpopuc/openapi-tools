<?php

namespace App\Services;

use App\Api\Specification;
use App\Validators\PathValidator;

class Compare
{
    public function execute(Specification $provider, Specification $consumer): array
    {
        $summary = [];
        $pathValidator = new PathValidator;
        foreach ($consumer->getPaths() as $path) {
            $summary = array_merge(
                $summary,
                $pathValidator->validate($provider, $consumer, $path)
            );
        }

        return $summary;
    }
}
