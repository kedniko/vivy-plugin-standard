<?php

namespace Tests;

use Kedniko\Vivy\V;

uses()->group('set-value');


test('set-value-int', function () {
    expect(
        V::int()->setValue(fn ($c) => $c->value / 100)->validate(10)->value()
    )->toBe(10 / 100);
});

test('set-value-string', function () {
    $v = V::string()->setValue('ok!');
    $validated = $v->validate('');
    expect($validated->isValid())->toBeTrue();
    expect($validated->value())->tobe('ok!');
});

test('simple-setvalue-2', function () {
    $v = V::group([
        'confirmed' => V::or([
            V::bool(),
            V::undefined()->setValue(false),
        ]),
    ]);
    $validated = $v->validate([]);
    expect($validated->isValid())->toBeTrue();
});
