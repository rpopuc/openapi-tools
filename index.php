<?php

use App\OpenApi\Builder;

error_reporting(E_ALL ^ E_DEPRECATED);

include('vendor/autoload.php');

$builder = new Builder;
$openapi = $builder->fromYamlFile(realpath('storage/pet-store-oa.yaml'));
print $openapi->getTitle() . PHP_EOL;
print $openapi->getVersion() . PHP_EOL;
foreach($openapi->getPaths() as $path) {
    $output = [
        "Path:",
        "  Endpoint: {$path->getEndpoint()}",
        "  Summary: {$path->getSummary()}",
        "  Description: {$path->getDescription()}",
        "  Parameters: ",
    ];

    foreach ($path->getParameters() as $parameter) {
        die($parameter->getName());
    }

    print implode(PHP_EOL, $output) . PHP_EOL;

    // $operations = $definition->getOperations();
    // foreach ($operations as $method => $operation) {
    //     foreach ($operation->parameters as $parameter) {
    //         print $parameter->schema->type . PHP_EOL;
    //     }
    // }
}
