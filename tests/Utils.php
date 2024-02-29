<?php

declare(strict_types=1);

namespace Tests;

use Kedniko\Vivy\Contracts\TypeInterface;

class Utils
{
  public static function expectToBe(TypeInterface $rule, array $keyValues)
  {

    foreach ($keyValues as $item) {
      $value = $item[0];
      $validated = $rule->validate($value);
      $valid = $validated->isValid();
      $res = $item[1];
      expect($valid)->toBe($res);
    }
  }
}
