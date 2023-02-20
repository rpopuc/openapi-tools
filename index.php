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
    ];

    $output[] = "  Parameters: ";
    foreach ($path->getParameters() as $parameter) {
        $output[] = "   {$parameter->getName()}";
    }

    $output[] = "  Operations: ";
    foreach ($path->getOperations() as $operation) {
        $output[] = "   Method: {$operation->getMethod()}";
        $output[] = "   Summary: {$operation->getSummary()}";
        $output[] = "   Description: {$operation->getDescription()}";
        $output[] = "   Parameters:";

        foreach ($operation->getParameters() as $parameter) {
            $output[] = "    {$parameter->getName()}";
            $output[] = "      Description: {$parameter->getDescription()}";
            $output[] = "      In: {$parameter->getIn()}";

            $schema = $parameter->getSchema();
            $output[] = "      Schema:";
            $output[] = "        Type: {$schema->getType()}";
        }
    }

    print implode(PHP_EOL, $output) . PHP_EOL;

    die();
}
