<?php

namespace Tests;

uses()->group('unit');

test('cast', function () {
  expect((array) 1)->toBe([1]);
});
