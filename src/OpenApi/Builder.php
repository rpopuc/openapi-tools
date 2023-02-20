<?php
namespace App\OpenApi;

use cebe\openapi\Reader;
use App\OpenApi\Specification as OpenApiSpecification;
use App\Api\Specification as SpecificationInterface;

class Builder
{
    public function fromYamlFile(string $filename): SpecificationInterface
    {
        $openapi = Reader::readFromYamlFile($filename);

        return new OpenApiSpecification($openapi);
    }
}
