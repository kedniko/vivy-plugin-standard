<?php

namespace Tests;

use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\Vivy\Core\GroupContext;
use Kedniko\Vivy\O;
use Kedniko\Vivy\V;

$faker = \Faker\Factory::create();
uses()->group('array');

test('array-int', function () {

    $data = [1, 2, 3, 4, 5, 6, 7];

    expect(V::array()
        ->count(7)
        ->each(V::int())->isValidWith($data))
        ->toBeTrue();

    expect(V::array()
        ->count(10)
        ->each(V::int())->isValidWith($data))
        ->toBeFalse();

    $err = V::array()
        ->count(10)
        ->each(V::int())->validate($data);
    expect(count($err->errors()['count']) === 1)->toBeTrue();
});

test('array-group', function () use ($faker) {
    $persona = V::group([
        'nome' => V::string(),
        'cognome' => V::string(),
        'email' => V::email()->toUppercase(),
        'data_nascita' => V::string(),
        'via' => V::string(),
        'citta' => V::string()->toUppercase()->toLowercase(),
        'stato' => V::string()->maxLength(2),
    ]);

    $v = V::array()->maxCount(20)->each($persona);

    $data = [];
    for ($i = 0; $i < 20; $i++) {
        $data[] = [
            'nome' => $faker->name(),
            'cognome' => $faker->lastName(),
            'email' => $faker->email(),
            'data_nascita' => $faker->date(),
            'via' => $faker->streetAddress(),
            'citta' => $faker->city(),
            'stato' => $faker->countryCode(),
        ];
    }

    $validated = $v->validate($data);

    expect($validated->isValid())->toBeTrue();
});

test('group-key-value', function () {
    $days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
    $data = [
        'workdays' => [
            'SUN' => true,
            'MON' => true,
            'TUE' => true,
            'WED' => true,
            'THU' => true,
            'FRI' => true,
            'SAT' => true,
        ],
    ];

    $validated = V::group([
        'workdays' => V::group()->addRule(V::rule(
            'key-values',
            function (GroupContext $c) use ($days) {
                $data = $c->value;
                foreach ($data as $key => $value) {
                    if (! in_array($key, $days)) {
                        $c->errors[$key]['key'][] = 'key not valid';
                    }

                    if (! is_bool($value)) {
                        $c->errors[$key]['value'][] = 'value not valid';
                    }
                }

                return true;
            }
        )),
    ])->validate($data);

    expect($validated->isValid())->toBeTrue();
});

test('in-array', function () {

    $message = O::message(function (ContextInterface $c) {
        $m = $c->getMiddleware();
        $id = $m->getID();
        $value = $c->value;

        return "Received [{$value}]";
    });

    $orNull = function ($rule) use ($message) {
        return V::or([
            V::undefined()->setValue(null),
            V::is([])->setValue(null),
            V::is('')->setValue(null),
            V::null()->setValue(null),
            $rule,
        ], $message);
    };

    $ruleLetters = V::string()
        ->in(
            ['6T', 'E2', 'E3', 'E4', 'E5', 'E6'],
            options: O::message(function (ContextInterface $c) {
                $m = $c->getMiddleware();
                $id = $m->getID();
                $value = $c->value;

                return "Received [{$value}]";
            })
        )
        ->length(2);

    $validated = $ruleLetters->validate('6T');
    expect($validated->isValid())->toBeTrue();

    $validated = V::group([
        'letters' => $orNull($ruleLetters),
    ])
        ->validate([
            'letters' => '6T',
        ]);

    expect($validated->isValid())->toBeTrue();
});
