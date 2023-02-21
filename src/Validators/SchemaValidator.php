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

        if ($consumerType === 'array') {
            $providerItemsType = $providerSchema->getItems();
            $consumerItemsType = $consumerSchema->getItems();
            return $summary->merge($this->validate($providerItemsType, $consumerItemsType));
        }

        if ($consumerType === 'object') {
            foreach ($consumerSchema->getProperties() as $property) {
                if (!$providerProperty = $providerSchema->getProperties()->getByName($property->getName())) {
                    $summary->addError('Property do not exists on provider: ' . $property->getName());
                    continue;
                }

                $summary->merge($this->validate($providerProperty, $property));
            }
        }

        return $summary;
    }
}
