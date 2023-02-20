<?php
require_once('vendor/autoload.php');

use cebe\openapi\Reader;

// realpath is needed for resolving references with relative Paths or URLs
// $openapi = Reader::readFromYamlFile('https://raw.githubusercontent.com/OAI/OpenAPI-Specification/3.0.2/examples/v3.0/petstore-expanded.yaml');

$openapi = Reader::readFromYamlFile(realpath('pet-store-3.0.yaml'));

echo $openapi->openapi; // openAPI version, e.g. 3.0.0
echo $openapi->info->title; // API title
foreach($openapi->paths as $path => $definition) {
    // iterate path definitions
}


$providerSpec = Reader::readFromYaml($provider->definition);
$consumerSpec = Reader::readFromYaml($provider->consumers[0]->definition);

$service = new ContractValidator;
$service->validate($providerSpec, $consumerSpec);


// ...
public function validate(OpenApiSpec $provider, OpenApiSpec $consumer): bool
{
    foreach ($consumer->getPaths() as $path) {
        $this->validatePath($path, $provider);
    }
}

