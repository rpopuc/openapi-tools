<?php

use App\OpenApi\Builder;

error_reporting(E_ALL ^ E_DEPRECATED);

include('vendor/autoload.php');

$builder = new Builder;
$provider = $builder->fromYamlFile(realpath($argv[1]));
$consumer = $builder->fromYamlFile(realpath($argv[2]));

$compare = new \App\Services\Compare();
$result = $compare->execu]te($provider, $consumer);

dump($result);
