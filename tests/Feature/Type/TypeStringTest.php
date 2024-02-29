<?php

use Tests\Utils;
use Kedniko\Vivy\O;
use Kedniko\Vivy\V;

uses()->group('type-string');

test('length-0', function () {
  Utils::expectValidToBe(
    V::string()->length(0),
    [
      ['', true],

      ['0', false],
      ['-1', false],
      ['string', false],
      [null, false],
      [true, false],
      [false, false],
      [[], false],
      [new stdClass(), false],
    ],
  );

  Utils::expectValidToBe(
    V::string()->length(4),
    [
      ['1234', true],
      ['name', true],

      ['string', false],
      ['', false],
      [null, false],
      [true, false],
      [false, false],
      [[], false],
      [new stdClass(), false],
    ],
  );
});


test('length-invalid-argument', function () {
  $isValid = false;
  try {
    V::string()->length(-1)->validate('');
    $isValid = false;
  } catch (\Throwable $th) {
    $isValid = true;
  }
  expect($isValid)->toBeTrue();
});

test('min-length-invalid-argument', function () {
  $isValid = false;
  try {
    V::string()->minLength(-1)->validate('');
    $isValid = false;
  } catch (\Throwable $th) {
    $isValid = true;
  }
  expect($isValid)->toBeTrue();
});

test('min-length', function () {
  Utils::expectValidToBe(
    V::string()->minLength(4),
    [
      ['1234', true],
      ['12345', true],
      ['1234567890', true],
      ['name', true],
      ['string', true],

      ['', false],
      [null, false],
      [true, false],
      [false, false],
      [[], false],
      [new stdClass(), false],
    ],
  );
  Utils::expectValidToBe(
    V::string()->minLength(0),
    [
      ['1234', true],
      ['12345', true],
      ['1234567890', true],
      ['name', true],
      ['', true],

      [null, false],
      [true, false],
      [false, false],
      [[], false],
      [new stdClass(), false],
    ],
  );
});

test('empty-string', function () {
  $v = V::emptyString();
  $validated = $v->validate('');
  expect($validated->isValid())->toBeTrue();
  expect($validated->value())->tobe('');
});

test('string-2', function () {
  $v = V::string()->intString();

  $values = [
    ['value' => '1', 'res' => true],
    ['value' => '10000', 'res' => true],
    ['value' => '-1', 'res' => true],
    ['value' => '-10000', 'res' => true],
    ['value' => '-0', 'res' => true],
    ['value' => '0', 'res' => true],
    ['value' => '-000001', 'res' => true],
    ['value' => '000001', 'res' => true],
  ];

  foreach ($values as $item) {
    $validated = $v->validate($item['value']);
    $valid = $validated->isValid();
    $res = $item['res'];
    expect($valid)->toBe($res);
  }
});
