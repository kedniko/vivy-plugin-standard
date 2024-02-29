<?php

namespace Kedniko\VivyPluginStandard;

use DateTime;
use Kedniko\Vivy\Context;
use Brick\Math\BigDecimal;
use Kedniko\Vivy\Core\Rule;
use Kedniko\Vivy\Support\Str;
use Kedniko\Vivy\Core\Helpers;
use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Support\Util;
use Kedniko\Vivy\Core\Constants;
use Kedniko\Vivy\Core\Undefined;
use Kedniko\Vivy\Messages\RuleMessage;
use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\VivyPluginStandard\Enum\RulesEnum;
use Kedniko\Vivy\Enum\RulesEnum as CoreRulesEnum;

final class Rules
{



    // public static function call(string $id): Rule
    // {
    //     $options = null;
    //     $args = [];

    //     foreach (array_slice(func_get_args(), 1) as $arg) {
    //         if ($arg instanceof Options) {
    //             $options = $arg;
    //         } else {
    //             $args[] = $arg;
    //         }
    //     }

    //     $options = Helpers::getOptions($options);

    //     if (!V::$magicCaller->hasId($id)) {
    //         throw new VivyMiddlewareNotFoundException("Middleware \"{$id}\" not found", 1);
    //     }

    //     $rule = V::$magicCaller->getId($id);
    //     $rule->setArgs($args);
    //     if ($options->getErrorMessage() !== null) {
    //         $rule->setErrorMessage($options->getErrorMessage());
    //     }
    //     $rule->setStopOnFailure($options->getStopOnFailure());

    //     return $rule;
    // }


    public static function notFalsy(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_NOT_FALSY->value;
        $ruleFn = fn (ContextInterface $c): bool => (bool) $c->value;
        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }




    public static function string(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_STRING->value;
        $ruleFn = function (ContextInterface $c): bool {
            $value = $c->value;
            return is_string($value);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function digitsString(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_DIGITS_STRING->value;
        $ruleFn = function (ContextInterface $c): bool {
            // $trim = Helpers::valueOrFunction($trim, $c);
            $value = $c->value;
            if (!is_string($value)) {
                return false;
            }

            // if ($trim) {
            //     $value = trim($value);
            // }

            return preg_match(Constants::REGEX_DIGITS, $value, $matches) === 1;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function intString(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_INTSTRING->value;
        $ruleFn = function (ContextInterface $c): bool {
            // $trim = Helpers::valueOrFunction($trim, $c);
            $value = $c->value;

            return self::isTypeIntString($value);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function boolString(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_BOOL_STRING->value;
        $ruleFn = fn (ContextInterface $c): bool => in_array($c->value, ['true', 'false'], true);
        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function boolValue(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_BOOL_VALUE->value;
        $ruleFn = fn (ContextInterface $c): bool => in_array($c->value, ['true', 'false', true, false, 0, 1, '0', '1'], true);
        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function intValue(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_INT_VALUE->value;
        $ruleFn = function (ContextInterface $c) {
            $value = $c->value;
            if (is_numeric($value)) {
                if (is_int($value) || intval($value) == $value) {
                    return true;
                }
            }

            return false;
        };
        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function intBool(bool $strict, string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_INTBOOL->value;
        $ruleFn = function (ContextInterface $c) use ($strict): bool|int {
            $strict = Helpers::valueOrFunction($strict, $c);
            if ($strict) {
                return in_array($c->value, [0, 1], true);
            }

            return is_int($c->value);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function file(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_FILE->value;
        $ruleFn = function (ContextInterface $c): bool {
            $value = $c->value;

            return isset($value['name']) &&
                isset($value['full_path']) &&
                isset($value['type']) &&
                isset($value['tmp_name']) &&
                isset($value['error']) &&
                isset($value['size']);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function int(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_INT->value;
        $ruleFn = fn (ContextInterface $c): bool => is_int($c->value);

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    // /**
    //  * Test method
    //  * @param mixed $errormessage
    //  * @return Rule
    //  */
    // public static function intWithClass(string|callable|null $errormessage = null)
    // {
    // 	$ruleID = RuleFunctions::RULE_NUMBER_INT;
    // 	$ruleFn = RuleFunctions::class . '::' . $ruleID;
    // 	$errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);
    // 	return new Rule($ruleID, $ruleFn, $errormessage);
    // }

    public static function floatOrInt(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_FLOAT_OR_INT->value;
        $ruleFn = fn (ContextInterface $c): bool => is_float($c->value) || is_int($c->value);

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function number(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_NUMBER->value;
        $ruleFn = fn (ContextInterface $c): bool => !is_string($c->value) && is_numeric($c->value);
        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function float(bool $strictFloat = true, string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_FLOAT->value;
        $ruleFn = function (ContextInterface $c) use ($strictFloat): bool {
            $strictFloat = Helpers::valueOrFunction($strictFloat, $c);
            if ($strictFloat) {
                return is_float($c->value);
            }

            return is_float($c->value) || is_int($c->value);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function floatString(bool $strictFloat,  string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_FLOAT_STRING->value;
        $ruleFn = function (ContextInterface $c) use ($strictFloat) {
            $strictFloat = Helpers::valueOrFunction($strictFloat, $c);
            // $trim = Helpers::valueOrFunction($trim, $c);

            return self::isTypeFloatString($strictFloat, $c->value);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    private static function isTypeIntString($value): bool
    {
        if (!is_string($value)) {
            return false;
        }

        // if ($trim) {
        //     $value = trim($value);
        // }

        return preg_match(Constants::REGEX_INTEGER_POSITIVE_OR_NEGATIVE, $value, $matches) === 1;
    }

    private static function isTypeFloatString(bool $strictFloat, mixed $value)
    {
        if (!is_string($value)) {
            return false;
        }

        // if ($trim) {
        //     $value = trim($value);
        // }

        $isTypeFloatString = preg_match(Constants::REGEX_FLOAT_POSITIVE_OR_NEGATIVE, $value, $matches) === 1;

        if ($strictFloat) {
            return $isTypeFloatString;
        }

        $isTypeIntString = preg_match(Constants::REGEX_INTEGER_POSITIVE_OR_NEGATIVE, $value, $matches) === 1;

        return $isTypeFloatString || $isTypeIntString;
    }

    public static function numberString(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_FLOAT_STRING->value;
        $ruleFn = function (ContextInterface $c): bool {
            // $trim = Helpers::valueOrFunction($trim, $c);
            if (!is_string($c->value)) {
                return false;
            }
            $isTypeIntString = self::isTypeIntString($c->value);

            $isTypeFloatString = self::isTypeFloatString(false, $c->value);

            return $isTypeIntString || $isTypeFloatString;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }


    public static function bool(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_BOOL->value;
        $ruleFn = fn (ContextInterface $c): bool => is_bool($c->value);

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function any(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_ANY->value;
        $ruleFn = function (ContextInterface $c): bool {
            return true;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function email(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_EMAIL->value;
        $ruleFn = function (ContextInterface $c): bool {
            if (!$c->value) {
                return false;
            }
            if (!is_string($c->value)) {
                return false;
            }

            return preg_match(Constants::REGEX_MAIL, $c->value) === 1;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }



    public static function phone(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_PHONE->value;
        $ruleFn = function (ContextInterface $c): bool {
            if (!$c->value) {
                return false;
            }
            if (!is_string($c->value)) {
                return false;
            }

            return preg_match(Constants::REGEX_CELLPHONE_WITH_OPTIONAL_PREFIX, $c->value) === 1;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    /**
     * @param  string  $format https://www.php.net/manual/en/datetime.format.php
     */
    public static function date(string $format = 'Y-m-d', string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_DATE->value;
        $ruleFn = function (ContextInterface $c) use ($format): bool {
            $format = Helpers::valueOrFunction($format, $c);
            if (!$c->value) {
                return false;
            }
            if (!is_string($c->value)) {
                return false;
            }

            $date = $c->value;

            $d = DateTime::createFromFormat($format, $date);

            return $d && $d->format($format) === $date;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function min(\Brick\Math\BigNumber|int|float|string $min, string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_MIN->value;
        $ruleFn = function (ContextInterface $c) use ($min): bool {
            try {
                $min = Helpers::valueOrFunction($min, $c);

                return BigDecimal::of($c->value)->isGreaterThanOrEqualTo(BigDecimal::of($min));
            } catch (\Throwable) {
                return false;
            }
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function max(\Brick\Math\BigNumber|int|float|string $max, string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_MAX->value;
        $ruleFn = function (ContextInterface $c) use ($max): bool {
            try {
                $max = Helpers::valueOrFunction($max, $c);

                return BigDecimal::of($c->value)->isLessThanOrEqualTo(BigDecimal::of($max));
            } catch (\Throwable) {
                return false;
            }
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function minDate(Datetime $date, string $sourceFormat = 'Y-m-d', string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_MIN_DATE->value;
        $ruleFn = function (ContextInterface $c) use ($date, $sourceFormat): bool {
            $date = Helpers::valueOrFunction($date, $c);
            $sourceFormat = Helpers::valueOrFunction($sourceFormat, $c);
            if ($c->value instanceof DateTime) {
                $given = $c->value;
            } else {
                $given = (new DateTime())->createFromFormat($sourceFormat, $c->value)->setTime(0, 0, 0, 0);
            }

            return $date <= $given;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function maxDate(Datetime $date, string $sourceFormat = 'Y-m-d', string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_MAX_DATE->value;
        $ruleFn = function (ContextInterface $c) use ($date, $sourceFormat): bool {
            $date = Helpers::valueOrFunction($date, $c);
            $sourceFormat = Helpers::valueOrFunction($sourceFormat, $c);
            if ($c->value instanceof DateTime) {
                $given = $c->value;
            } else {
                $given = (new DateTime())->createFromFormat($sourceFormat, $c->value)->setTime(0, 0, 0, 0);
            }

            return $given <= $date;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function between(Datetime $minDate, Datetime $maxDate, string $sourceFormat = 'Y-m-d', string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_DATE_BETWEEN->value;
        $ruleFn = function (ContextInterface $c) use ($minDate, $maxDate, $sourceFormat): bool {
            $minDate = Helpers::valueOrFunction($minDate, $c);
            $maxDate = Helpers::valueOrFunction($maxDate, $c);
            $sourceFormat = Helpers::valueOrFunction($sourceFormat, $c);
            if ($c->value instanceof DateTime) {
                $given = $c->value;
            } else {
                $given = (new DateTime())->createFromFormat($sourceFormat, $c->value)->setTime(0, 0, 0, 0);
            }

            return $minDate <= $given && $given <= $maxDate;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function notBetween(Datetime $minDate, Datetime $maxDate, string $sourceFormat = 'Y-m-d', string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_DATE_BETWEEN->value;
        $ruleFn = function (ContextInterface $c) use ($minDate, $maxDate, $sourceFormat): bool {
            $minDate = Helpers::valueOrFunction($minDate, $c);
            $maxDate = Helpers::valueOrFunction($maxDate, $c);
            $sourceFormat = Helpers::valueOrFunction($sourceFormat, $c);
            if ($c->value instanceof DateTime) {
                $given = $c->value;
            } else {
                $given = (new DateTime())->createFromFormat($sourceFormat, $c->value)->setTime(0, 0, 0, 0);
            }

            return !($minDate <= $given && $given <= $maxDate);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function array(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_ARRAY->value;
        $ruleFn = fn (ContextInterface $c): bool => is_array($c->value);

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function orderedIndexedArray(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_ORDERED_INDEXED_ARRAY->value;
        $ruleFn = fn (ContextInterface $c): bool => Util::isOrderedIndexedArray($c->value);

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }


    public static function regex($regex, string $ruleID, string|callable $errormessage = null): Rule
    {
        return new Rule($ruleID, function (ContextInterface $c) use ($regex): bool {
            if (!$c->value) {
                return false;
            }
            if (!is_string($c->value)) {
                return false;
            }

            return preg_match($regex, $c->value, $matches) === 1;
        }, $errormessage);
    }

    public static function notRegex($regex, string $ruleID, string|callable $errormessage = null): Rule
    {
        return new Rule($ruleID, function (ContextInterface $c) use ($regex): bool {
            if (!$c->value) {
                return false;
            }
            if (!is_string($c->value)) {
                return false;
            }

            return preg_match($regex, $c->value, $matches) !== 1;
        }, $errormessage);
    }

    public static function scalar(string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_SCALAR->value;
        $ruleFn = fn (ContextInterface $c): bool => is_scalar($c->value);

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function inArray(array $array, bool $strict = true, string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_IN_ARRAY->value;
        $ruleFn = function (ContextInterface $c) use ($array, $strict): bool {
            $array = Helpers::valueOrFunction($array, $c);
            $strict = Helpers::valueOrFunction($strict, $c);

            if ($c->value === 'nazionale') {
                $a = 1;
            }
            return in_array($c->value, $array, $strict);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function notInArray(array $array, bool $strict = true, string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_NOT_IN_ARRAY->value;
        $ruleFn = function (ContextInterface $c) use ($array, $strict): bool {
            $array = Helpers::valueOrFunction($array, $c);

            return !in_array($c->value, $array, $strict);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage('default.' . $ruleID);

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function ruleEndsWith(string $endsWith, bool $ignoreCase = true, string|callable $errormessage = null): Rule
    {
        $ruleID = 'endsWith';
        $ruleFn = function (ContextInterface $c) use ($endsWith, $ignoreCase): bool {
            $endsWith = Helpers::valueOrFunction($endsWith, $c);
            $ignoreCase = Helpers::valueOrFunction($ignoreCase, $c);
            if (!$c->value) {
                return false;
            }
            if (!is_string($c->value)) {
                return false;
            }

            return Str::endsWith($c->value, $endsWith, $ignoreCase);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage("default.{$ruleID}");

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function stringStartsWith(string $startsWith, bool $ignoreCase = true, string|callable $errormessage = null): Rule
    {
        $ruleID = 'startsWith';
        $ruleFn = function (ContextInterface $c) use ($startsWith, $ignoreCase): bool {
            $startsWith = Helpers::valueOrFunction($startsWith, $c);
            $ignoreCase = Helpers::valueOrFunction($ignoreCase, $c);
            if (!$c->value) {
                return false;
            }
            if (!is_string($c->value)) {
                return false;
            }

            return Str::startsWith($c->value, $startsWith, $ignoreCase);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage("default.{$ruleID}");

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function ruleContains(string $contains, bool $ignoreCase = true, string|callable $errormessage = null): Rule
    {
        $ruleID = 'contains';
        $ruleFn = function (ContextInterface $c) use ($contains, $ignoreCase): bool {
            $contains = Helpers::valueOrFunction($contains, $c);
            $ignoreCase = Helpers::valueOrFunction($ignoreCase, $c);
            if (!$c->value) {
                return false;
            }
            if (!is_string($c->value)) {
                return false;
            }

            return Str::contains($c->value, $contains, $ignoreCase);
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage("default.{$ruleID}");

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function stringMinLength(int $length, string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_MINLENGTH->value;
        $ruleFn = function (ContextInterface $c) use ($length): bool {
            $length = Helpers::valueOrFunction($length, $c);
            if (!is_string($c->value)) {
                return false;
            }

            return strlen($c->value) >= $length;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage("default.{$ruleID}");

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function stringMaxLength(int $length, string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_MAXLENGTH->value;
        $ruleFn = function (ContextInterface $c) use ($length): bool {
            $length = Helpers::valueOrFunction($length, $c);

            if (!is_string($c->value)) {
                return false;
            }

            return strlen($c->value) <= $length;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage("default.{$ruleID}");

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public static function stringLength(int $length, string|callable $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_LENGTH->value;
        $ruleFn = function (ContextInterface $c) use ($length): bool {
            $length = Helpers::valueOrFunction($length, $c);

            if (!is_string($c->value)) {
                return false;
            }

            return strlen($c->value) === $length;
        };

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage("default.{$ruleID}");

        return new Rule($ruleID, $ruleFn, $errormessage);
    }
}
