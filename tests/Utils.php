<?php

declare(strict_types=1);

namespace Tests;

use Kedniko\Vivy\Contracts\TypeInterface;

class Utils
{
    public static function expectValidToBe(TypeInterface $rule, array $keyValues, bool $debug = false)
    {

        foreach ($keyValues as $item) {
            $value = $item[0];
            $validated = $rule->validate($value);
            $valid = $validated->isValid();
            $res = $item[1];
            if ($debug && $valid !== $res) {
                dump($validated->errors());
            }
            expect($valid)->toBe($res);
        }
    }

    public static function expectValueToBe(TypeInterface $rule, array $keyValues, bool $debug = false)
    {

        foreach ($keyValues as $item) {
            $value = $item[0];
            $validated = $rule->validate($value);
            $value = $validated->value();
            $res = $item[1];
            if ($debug && $value !== $res) {
                dump($validated->errors());
            }
            expect($value)->toBe($res);
        }
    }
}
