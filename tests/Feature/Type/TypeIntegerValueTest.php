<?php

namespace Tests;

use Kedniko\Vivy\V;

uses()->group('intValue');


test('intValue', function () {

    Utils::expectValidToBe(
        V::intValue(),
        [
            ['12', true],
            [12, true],
            [0, true],
            ['0', true],

            [12.5, false],
            [0.001, false],
            ['0.001', false],
            [null, false],
            ['', false],
            [[], false],
            [new \stdClass(), false],
        ],
    );
});

test('intValue-toint', function () {

    $obj = new \stdClass();

    Utils::expectValueToBe(
        V::intValue()->toInt(),
        [
            ['12', 12],
            [12, 12],
            [0, 0],
            ['0', 0],

            [12.5, 12.5],
            [0.001, 0.001],
            ['0.001', '0.001'],
            [null, null],
            ['', ''],
            [[], []],
            [$obj, $obj],
        ],
        debug: true,
    );
});
