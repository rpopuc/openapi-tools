<?php

use App\OpenApi\Builder;
use App\Utils\Output;

error_reporting(E_ALL ^ E_DEPRECATED);

include('vendor/autoload.php');

$output = new Output;
$builder = new Builder;
$openapi = $builder->fromYamlFile(realpath($argv[1]));
print $openapi->getTitle() . PHP_EOL;
print $openapi->getVersion() . PHP_EOL;
foreach($openapi->getPaths() as $path) {
    $output->add("Path");

    $output->up()
        ->add("Endpoint: {$path->getEndpoint()}")
        ->add("Summary: {$path->getSummary()}")
        ->add("Description: {$path->getDescription()}");

    $output->add('Parameters: ')->up();
    foreach ($path->getParameters() as $parameter) {
        $output->add($parameter->getName());
    }
    $output->down();

    $output->add('Operations:')->up();
    foreach ($path->getOperations() as $operation) {
        $output->add("Method: {$operation->getMethod()}");
        $output->up()
            ->add("Summary: {$operation->getSummary()}")
            ->add("Description: {$operation->getDescription()}");

        $output->add("Parameters:");
        $output->up();
        foreach ($operation->getParameters() as $parameter) {
            $output->add($parameter->getName());
            $output->up();
                $output->add("Description: {$parameter->getDescription()}");
                $output->add("In: {$parameter->getIn()}");

                $schema = $parameter->getSchema();
                $output->up();
                    $output->add('Schema:');
                    $output->up();
                        $output->add("Type: {$schema->getType()}");
                    $output->down();
                $output->down();
            $output->down();
        }

        if ($operation->getRequestBody()) {
            $contents = $operation->getRequestBody()->getContent();
            $output->add('Request body:')->up();
            foreach ($operation->getRequestBody()->getContent() as $mediaType) {
                $output->add($mediaType->getType());
                $output->up();
                $output->add('Schema:');
                $output->up();
                foreach ($mediaType->getSchema()->getProperties() as $property) {
                    $output->add($property->getName());
                    $output->up();
                    $output->add("Type: " . $property->getType());
                    $output->add("Description: " . $property->getDescription());
                    $output->add("Format: " . $property->getFormat());
                    $output->down();
                }
                $output->down();
                $output->down();
            }
        }
    }

    print $output->join() . PHP_EOL;
    die();
}
