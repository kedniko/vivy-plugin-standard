<?php

namespace Tests;

use Kedniko\Vivy\V;

uses()->group('string');


test('string-1', function () {
    $v = V::string()->length(4);
    $validated = $v->validate('1234');
    expect($validated->isValid())->toBeTrue();
});

test('empty-string', function () {
    $v = V::emptyString();
    $validated = $v->validate('');
    expect($validated->isValid())->toBeTrue();
    expect($validated->value())->tobe('');
});
