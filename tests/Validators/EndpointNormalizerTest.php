<?php

use App\Validators\EndpointNormalizer;

test('Normalize simple endpoint', function () {
    $endpoint = '/simple/endpoint/';

    $normalizer = new EndpointNormalizer();
    $result = $normalizer->normalize($endpoint);

    expect($result)->toBe('/simple/endpoint');
});

test('Normalize endpoint with parameters', function () {
    $endpoint = '/first/{parameter}/second/{other_parameter}/';

    $normalizer = new EndpointNormalizer();
    $result = $normalizer->normalize($endpoint);

    expect($result)->toBe('/first/{1}/second/{2}');
});

