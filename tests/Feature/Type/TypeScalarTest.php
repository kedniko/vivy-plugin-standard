<?php

use Kedniko\Vivy\O;
use Kedniko\Vivy\Support\Util;
use Kedniko\Vivy\V;
use Tests\Utils;

uses()->group('type-scalar');

test('test-in-strict', function () {

  Utils::expectToBe(
    V::string()->in(['active', 'inactive'], true),
    [
      ['active', true],
      ['inactive', true],
      [null, false],
      ['', false],
      [true, false],
      [false, false],
      [[], false],
      [new stdClass(), false],
    ],
  );
});


test('test-in-array', function () {

  $values = ['', null, '2', '3', 2, 3, true, false, [],];

  foreach ([true, false] as $strict) {
    foreach ($values as $val) {
      $v = V::in($values, $strict);
      $validated = $v->validate($val);
      $is_valid = in_array($val, $values, $strict);
      expect($validated->isValid())->toBe($is_valid);
    }
  }
});

test('test-in-array-version-object', function () {

  $values = [new stdClass(), '', null, '2', '3', true, false, [],];

  foreach ([true, false] as $strict) {
    foreach ($values as $val) {
      $v = V::in($values, $strict);
      $validated = $v->validate($val);
      $is_valid = in_array($val, $values, $strict);
      expect($validated->isValid())->toBe($is_valid);
    }
  }
});
