<?php

namespace Tests;

use App\App;
use Kedniko\Vivy\O;
use Kedniko\Vivy\V;

uses()->group('group');

beforeAll(function () {
    App::boot();
});

test('group-1', function () {
    $validated = V::group([
        'name' => V::string(O::message('name is not a string')),
        'count' => V::int()->max(100, O::message('count is too big')),
        'address' => [
            'address' => V::string(),
            'city' => V::string(),
            'country' => V::string()->length(3, O::message('Length invalid')),
        ],
    ])->validate([
        'name' => 3,
        'count' => 340,
        'address' => [
            'address' => 'main street',
            'city' => 'new York',
            'country' => 'PL',
        ],
    ]);

    expect($validated->isValid())->toBeFalse();

    $errorsExpected = [
        'name' => [
            'string' => ['name is not a string'],
        ],
        'count' => [
            'max' => ['count is too big'],
        ],
        'address' => [
            'country' => [
                'length' => ['Length invalid'],
            ],
        ],
    ];

    expect($validated->errors())->toBe($errorsExpected);
});

test('group-2', function () {
    $emailSchema = [
        'name' => V::string(O::message('Name invalid')),
        'email_address' => V::email(O::message('Email invalid')),
        'newsletter_active' => V::bool(), // messaggio di errore di default
    ];

    $schema = V::group([
        'name' => V::string(O::message('Name invalid')),
        'surname' => V::string(O::message('Surname invalid')),
        'emails' => V::array()->each($emailSchema),
    ]);

    $validated = $schema->validate([
        'name' => 'John',
        'surname' => 'Doe',
        'emails' => [
            [
                'name' => 'John 1',
                'email_address' => 'john1_wrong_email',
                'newsletter_active' => true,
            ],
            [
                'name' => 'John 2',
                'email_address' => 'john2@example.com',
                'newsletter_active' => false,
            ],
        ],
    ]);

    $is_valid = $validated->isValid(); // true
    $errors = $validated->errors();
    $expectedErrors = [
        'emails' => [
            0 => [
                'email_address' => [
                    'email' => [
                        'Email invalid',
                    ],
                ],
            ],
        ],
    ];

    expect($is_valid)->toBeFalse();
    expect($errors)->toBe($expectedErrors);
});
