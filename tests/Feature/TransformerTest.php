<?php

namespace Tests;

use Kedniko\Vivy\Core\GroupContext;
use Kedniko\Vivy\V;

uses()->group('transformer');

test('transformer-1', function () {
    $v = V::group([
        'name' => V::string()->addTransformer(function (GroupContext $gc) {
            return strtoupper($gc->value);
        }),
        'password' => V::string(),
    ]);

    $validated = $v->validate([
        'name' => 'niko',
    ]);

    expect($validated->value())->tobe([
        'name' => 'NIKO',
    ]);

    expect($validated->errors())->toBe([
        'password' => [
            'required' => ['Questo campo è obbligatorio'],
        ],
    ]);
});
