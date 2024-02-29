<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Transformer;
use Kedniko\Vivy\Core\Constants;
use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\Vivy\Messages\TransformerMessage;
use Kedniko\Vivy\Exceptions\VivyTransformerException;
use Kedniko\VivyPluginStandard\Enum\TransformersEnum;

final class Transformers
{


    public static function trim($characters = " \t\n\r\0\x0B", $errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_TRIM->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c) use ($characters): ?string {
            $value = $c->value;
            if ($value === null) {
                return $value;
            }
            if (!is_string($value)) {
                throw new VivyTransformerException();
            }

            return trim($value, $characters);
        }, $errormessage);
    }

    public static function ltrim($characters = " \t\n\r\0\x0B", $errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_LTRIM->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c) use ($characters): string {
            $value = $c->value;
            if (!is_string($value)) {
                throw new VivyTransformerException();
            }

            return ltrim($value, $characters);
        }, $errormessage);
    }

    public static function rtrim($characters = " \t\n\r\0\x0B", $errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_RTRIM->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c) use ($characters): string {
            $value = $c->value;
            if (!is_string($value)) {
                throw new VivyTransformerException();
            }

            return rtrim($value, $characters);
        }, $errormessage);
    }

    public static function toUpperCase($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_TO_UPPER_CASE->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c): string {
            $value = $c->value;
            if (!is_string($value)) {
                throw new VivyTransformerException();
            }

            return strtoupper($value);
        }, $errormessage);
    }

    public static function toLowerCase($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_TO_LOWER_CASE->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c): string {
            $value = $c->value;
            if (!is_string($value)) {
                throw new VivyTransformerException();
            }

            return mb_strtolower($value, 'UTF-8');
        }, $errormessage);
    }

    public static function firstLetterUpperCase($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_FIRST_LETTER_UPPER_CASE->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c): string {
            $value = $c->value;
            if (!is_string($value)) {
                throw new VivyTransformerException();
            }

            return ucfirst($value);
        }, $errormessage);
    }

    public static function firstLetterLowerCase($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_FIRST_LETTER_LOWER_CASE->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c): string {
            $value = $c->value;
            if (!is_string($value)) {
                throw new VivyTransformerException();
            }

            return lcfirst($value);
        }, $errormessage);
    }

    /**
     * @todo support integers bigger than "2147483647" https://www.php.net/manual/en/function.intval.php
     *
     * @param  null  $errormessage
     *
     * @throws VivyTransformerException
     */
    public static function stringToInt($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_STRING_TO_INT->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c): int {
            $value = $c->value;

            if (!is_string($value)) {
                throw new VivyTransformerException('This is not a string');
            }

            $isTypeIntString = preg_match(Constants::REGEX_INTEGER_POSITIVE_OR_NEGATIVE, $value) === 1;
            if (!$isTypeIntString) {
                throw new VivyTransformerException('String does not contain an integer');
            }

            return (int) $value;
        }, $errormessage);
    }

    public static function stringBoolToBool($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_STRING_TO_BOOL->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c): bool {
            $value = $c->value;

            if (!is_string($value)) {
                throw new VivyTransformerException(json_encode($value, JSON_THROW_ON_ERROR) . ' is not a string');
            }

            if (!in_array($c->value, ['true', 'false'], true)) {
                throw new VivyTransformerException($value . ' is not allowed in strict mode');
            }

            return $value === 'true';
        }, $errormessage);
    }

    public static function boolValueToBool($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_BOOL_VALUE_TO_BOOL->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c): bool {
            $value = $c->value;

            if (in_array($value, ['true', 'false'], true)) {
                return $value === 'true';
            }

            if (in_array($value, ['1', '0'], true)) {
                return $value === '1';
            }

            if (in_array($value, [true, false], true)) {
                return $value === true;
            }

            if (in_array($value, [1, 0], true)) {
                return $value === 1;
            }

            throw new VivyTransformerException($value . ' is not allowed');
        }, $errormessage);
    }

    public static function intValueToInt($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_INT_VALUE_TO_INT->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c): int {
            $value = $c->value;

            if (is_scalar($value)) {
                $val = intval($value);
                return $val;
            }

            throw new VivyTransformerException($value . ' is not allowed');
        }, $errormessage);
    }

    public static function intToString($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_INT_TO_STRING->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c) {
            $value = $c->value;

            if (!is_int($value)) {
                throw new VivyTransformerException();
            }

            try {
                return (string) $value;
            } catch (\Exception) {
                throw new VivyTransformerException();
            }
        }, $errormessage);
    }

    public static function numberToString($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_NUMBER_TO_STRING->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c) {
            $value = $c->value;

            if (!is_int($value) && !is_float($value)) {
                throw new VivyTransformerException();
            }

            try {
                return (string) $value;
            } catch (\Exception) {
                throw new VivyTransformerException();
            }
        }, $errormessage);
    }

    public static function boolToInt($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_BOOL_TO_INT->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c): int {
            $value = $c->value;

            if (!is_bool($value)) {
                throw new VivyTransformerException('This is not a bool');
            }

            return $value ? 1 : 0;
        }, $errormessage);
    }

    public static function boolToString($errormessage = null): Transformer
    {
        $transformerID = TransformersEnum::ID_BOOL_TO_STRING->value;
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage($transformerID);

        return new Transformer($transformerID, function (ContextInterface $c): string {
            $value = $c->value;

            if (!is_bool($value)) {
                throw new VivyTransformerException('This is not a bool');
            }

            return $value ? 'true' : 'false';
        }, $errormessage);
    }
}
