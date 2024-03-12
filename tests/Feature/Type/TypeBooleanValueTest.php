<?php

namespace Tests;

use Kedniko\Vivy\V;

uses()->group('boolValue');

test('boolValue', function () {

    Utils::expectValidToBe(
        V::boolValue(),
        [
            ['true', true],
            ['false', true],
            [true, true],
            [false, true],
            [0, true],
            [1, true],
            ['0', true],
            ['1', true],

            [null, false],
            ['', false],
            [[], false],
            [new \stdClass(), false],
        ],
    );
});
test('boolValueStdClass', function () {

    $obj = new \stdClass();

    Utils::expectValueToBe(
        V::boolValue()->toBool(),
        [
            ['true', true],
            ['false', false],
            [true, true],
            [false, false],
            [0, false],
            [1, true],
            ['0', false],
            ['1', true],

            [null, null],
            ['', ''],
            [[], []],
            [$obj, $obj],
        ],
    );
});
