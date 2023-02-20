<?php

use App\Validators\Summary;

test('Summary is valid by default', function () {
    $summary = new Summary;

    expect($summary->isValid())->toBeTrue();
});

test('Is invalid when has an error', function () {
    $summary = new Summary;

    $summary->addError('Some error');

    expect($summary->isValid())->toBeFalse();
});

test('Manipulate errors', function () {
    $summary = new Summary;

    $summary->addError('Some error');

    expect($summary->getErrors())->toBe([
        'Some error'
    ]);
});
