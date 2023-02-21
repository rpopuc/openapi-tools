<?php

namespace App\Validators;

use App\Api\Schema;
use App\Api\Specification;

class SchemaValidator
{
    public function validate(Schema $providerSchema, Schema $consumerSchema): Summary
    {
        $summary = new Summary();
        $providerType = $providerSchema->getType();
        $consumerType = $consumerSchema->getType();

        if ($consumerType !== $providerType) {
            $summary->addError("expected type '{$providerType}', not '{$consumerType}'");
        }

        return $summary;
    }
}
