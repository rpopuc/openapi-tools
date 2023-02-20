<?php

namespace App\Validators;

class EndpointNormalizer
{
    public function normalize(string $endpoint): string
    {
        $count = 0;
        return rtrim(preg_replace_callback('/{.*?}/', function() use (&$count) {
            ++$count;
            return "{{$count}}";
        }, $endpoint), ' /');
    }
}
