<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Callback;
use Kedniko\Vivy\Contracts\TypeInterface;
use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Enum\RulesEnum as CoreRulesEnum;
use Kedniko\Vivy\Interfaces\VivyPlugin;
use Kedniko\Vivy\Messages\RuleMessage;
use Kedniko\Vivy\Rules as CoreRules;
use Kedniko\Vivy\Support\Registrar;
use Kedniko\Vivy\Support\Util;
use Kedniko\Vivy\Type;
use Kedniko\Vivy\Type\TypeAny;
use Kedniko\Vivy\Type\TypeGroup;
use Kedniko\Vivy\Type\TypeOr;
use Kedniko\Vivy\V;

final class StandardLibrary implements VivyPlugin
{
    public function register(): void
    {

        V::registerMany([

            // other

            Registrar::make('any')->for(V::class)->callback([self::class, 'any'])->return(Type::class),
            Registrar::make('or')->for([V::class, TypeAny::class, Type::class])->callback([self::class, 'or'])->return(TypeOr::class),
            Registrar::make('group')->for([V::class, TypeAny::class, Type::class])->callback([self::class, 'group'])->return(TypeGroup::class),
            Registrar::make('in')->for([V::class, TypeAny::class, Type::class])->callback([self::class, 'in'])->return(TypeScalar::class),
            Registrar::make('is')->for([V::class, TypeAny::class, Type::class])->callback([self::class, 'is'])->return(TypeAny::class),
            Registrar::make('notIs')->for([V::class, TypeAny::class, Type::class])->callback([self::class, 'notIs'])->return(TypeAny::class),
            Registrar::make('undefined')->for([V::class, TypeAny::class, Type::class])->callback([self::class, 'undefined'])->return(TypeUndefined::class),
            Registrar::make('null')->for([V::class, TypeAny::class, Type::class])->callback([self::class, 'null'])->return(TypeNull::class),
            Registrar::make('array')->for([V::class, TypeAny::class, Type::class])->callback([self::class, 'array'])->return(TypeArray::class),

            // numbers

            Registrar::make('int')->for([V::class, TypeAny::class])->callback([self::class, 'int'])->return(TypeInt::class),
            Registrar::make('intValue')->for([V::class, TypeAny::class])->callback([self::class, 'intValue'])->return(TypeIntValue::class),
            Registrar::make('float')->for([V::class, TypeAny::class])->callback([self::class, 'float'])->return(TypeFloat::class),
            Registrar::make('number')->for([V::class, TypeAny::class])->callback([self::class, 'number'])->return(TypeNumber::class),
            Registrar::make('digits')->for([TypeString::class])->callback([self::class, 'digits'])->return(TypeString::class),
            Registrar::make('floatString')->for([V::class, TypeAny::class])->callback([self::class, 'floatString'])->return(TypeStringFloat::class),
            Registrar::make('numberString')->for([V::class, TypeAny::class])->callback([self::class, 'numberString'])->return(TypeStringNumber::class),
            Registrar::make('intString')->for([V::class, TypeAny::class])->callback([self::class, 'intString'])->return(TypeStringInt::class),

            // bool

            Registrar::make('bool')->for([V::class, TypeAny::class])->callback([self::class, 'bool'])->return(TypeBool::class),
            Registrar::make('boolString')->for([V::class, TypeAny::class])->callback([self::class, 'boolString'])->return(TypeStringBool::class),
            Registrar::make('boolValue')->for([V::class, TypeAny::class])->callback([self::class, 'boolValue'])->return(TypeBoolValue::class),

            // string

            Registrar::make('email')->for([V::class, TypeAny::class])->callback([self::class, 'email'])->return(TypeStringEmail::class),
            Registrar::make('emptyString')->for([V::class, TypeAny::class])->callback([self::class, 'emptyString'])->return(TypeStringEmpty::class),
            Registrar::make('notEmptyString')->for([V::class, TypeAny::class])->callback([self::class, 'notEmptyString'])->return(TypeString::class),
            Registrar::make('string')->for([V::class, TypeAny::class])->callback([self::class, 'string'])->return(TypeString::class),
            Registrar::make('date')->for([V::class, TypeString::class, TypeAny::class])->callback([self::class, 'date'])->return(TypeStringDate::class),

            // casts

            Registrar::make('asAny')->for([V::class, Type::class])->callback([self::class, 'asAny'])->return(TypeAny::class),
            Registrar::make('asArray')->for([V::class, Type::class])->callback([self::class, 'asArray'])->return(TypeArray::class),
            Registrar::make('asFile')->for([V::class, Type::class])->callback([self::class, 'asFile'])->return(TypeFile::class),
            Registrar::make('asBool')->for([V::class, Type::class])->callback([self::class, 'asBool'])->return(TypeBool::class),
            Registrar::make('asDate')->for([V::class, Type::class])->callback([self::class, 'asDate'])->return(TypeStringDate::class),
            Registrar::make('asEmail')->for([V::class, Type::class])->callback([self::class, 'asEmail'])->return(TypeStringEmail::class),
            Registrar::make('asScalar')->for([V::class, Type::class])->callback([self::class, 'asScalar'])->return(TypeScalar::class),
            Registrar::make('asFloat')->for([V::class, Type::class])->callback([self::class, 'asFloat'])->return(TypeFloat::class),
            Registrar::make('asGroup')->for([V::class, Type::class])->callback([self::class, 'asGroup'])->return(TypeGroup::class),
            Registrar::make('asInt')->for([V::class, Type::class])->callback([self::class, 'asInt'])->return(TypeInt::class),
            Registrar::make('asIntString')->for([V::class, Type::class])->callback([self::class, 'asIntString'])->return(TypeStringInt::class),
            Registrar::make('asNumber')->for([V::class, Type::class])->callback([self::class, 'asNumber'])->return(TypeNumber::class),
            Registrar::make('asString')->for([V::class, Type::class])->callback([self::class, 'asString'])->return(TypeString::class),

            // experimental

            Registrar::make('file')->for([V::class, TypeAny::class])->callback([self::class, 'file'])->return(TypeFile::class),
            Registrar::make('files')->for([V::class, TypeAny::class])->callback([self::class, 'files'])->return(TypeFiles::class),

            // [[RootType::class], 'asAny', [self::class, 'asAny'], RootType::class], //
            // [V::class, 'and', [self::class, 'and'], TypeOr::class],
            // [V::class, 'intWithClass', [self::class, 'intWithClass'], TypeInt::class],
            // [V::class, 'inArray', [Rules::class, 'inArray'], Type::class],
            // [V::class, 'notInArray', [Rules::class, 'notInArray'], Type::class],
            // [V::class, 'equals', [Rules::class, 'equals'], Type::class],
            // [V::class, 'optional', [self::class, 'optional'], Type::class], // TODO
            // [[V::class, TypeAny::class, Type::class], 'make', [self::class, 'make'], TypeMake::class], //
            // [[V::class, TypeAny::class, Type::class], 'everything', [self::class, 'everything'], TypeEverything::class], //
            // [[V::class, TypeAny::class, Type::class], 'notFalsy', [self::class, 'notFalsy'], TypeNotFalsy::class], //
            // [[V::class, TypeAny::class, Type::class], 'notNull', [self::class, 'notNull'], TypeNotNull::class], //

        ]);
    }

    public static function any(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = Type::new(from: $obj);
            $type->addRule(Rules::any($options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function email(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeStringEmail::new(from: $obj);
            $type->addRule(Rules::email($options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function group(array|callable|TypeGroup|null $setup = null, bool $stopOnFieldFailure = false, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $fromObj) use ($setup, $stopOnFieldFailure, $options) {
            if ($setup instanceof TypeGroup) {
                return $setup;
            }

            $typeGroup = TypeGroup::new(from: $fromObj);
            $typeGroup->init($setup);
            $typeGroup->addRule(Rules::array($options->getErrorMessage()), $options);
            $typeGroup->addRule(
                rule: $typeGroup->getGroupRule($stopOnFieldFailure, $options->getErrorMessage()),
                options: $options
            );

            return $typeGroup;
        };
    }

    /**
     * @param  TypeInterface[]  $types
     */
    public static function or(array $types, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($types, $options) {
            return TypeOr::new(from: $obj)->init($types, false, $options);
        };
    }

    // /**
    //  * @param Type[] $types
    //  * @param Options|null $options
    //  */
    // public static function and(array $types, Options $options = null)
    // 	$options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
    // {
    // 	$type = new TypeOr($types, false, $options);
    // 	return $type;
    // }

    public static function notIn(array $array, bool $strict = true, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options, $array, $strict) {
            $type = TypeScalar::new(from: $obj);
            $type->addRule(Rules::notInArray($array, $strict, $options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function file(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeFile::new(from: $obj);
            $type->addRule(Rules::file($options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function int(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeInt::new(from: $obj);
            $type->addRule(Rules::int($options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function is($value, bool $strict = true, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options, $value, $strict) {
            $type = TypeAny::new(from: $obj);
            $type->addRule(CoreRules::equals($value, $strict, $options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function notIs($value, bool $strict = true, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options, $value, $strict) {
            $type = TypeAny::new(from: $obj);
            $type->addRule(CoreRules::notEquals($value, $strict, $options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function in(array $array, bool $strict = true, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options, $array, $strict) {
            $type = TypeScalar::new(from: $obj);
            $type->addRule(Rules::inArray($array, $strict, $options->getErrorMessage()), $options);

            return $type;
        };
    }

    // public static function intWithClass(Options $options = null)
    // 	$options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
    // {
    // 	$type = new TypeInt();
    // 	$type->addRule(Rules::intWithClass($options->getErrorMessage()), $options);
    // 	return $type;
    // }

    public static function bool(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeBool::new(from: $obj);
            $type->addRule(Rules::bool($options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function float($strictFloat = false, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($strictFloat, $options): \Kedniko\VivyPluginStandard\TypeFloat {
            $type = new TypeFloat();
            $type->addRule(Rules::float($strictFloat, $options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function number(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeNumber::new(from: $obj);
            $type->addRule(Rules::floatOrInt($options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function numberString(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeStringNumber::new(from: $obj);
            $type->addRule(Rules::numberString(false, $options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function string(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeString::new(from: $obj);
            $type->addRule(Rules::string($options->getErrorMessage()), $options);
            // $type->allowEmptyString();

            return $type;
        };
    }

    public static function digits(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeStringInt::new(from: $obj);
            $type->addRule(Rules::digitsString(false, $options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function intString(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeStringInt::new(from: $obj);
            $type->addRule(Rules::intString(false, $options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function boolString(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeStringBool::new(from: $obj);
            $type->addRule(Rules::boolString($options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function boolValue(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeBoolValue::new(from: $obj);
            $type->addRule(Rules::boolValue($options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function intValue(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeIntValue::new(from: $obj);
            $type->addRule(Rules::intValue($options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function floatString($strict = true, $trim = false, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($strict, $trim, $options) {
            $type = TypeStringInt::new(from: $obj);
            $type->addRule(Rules::floatString($strict, $trim, $options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function date($format = 'Y-m-d', ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($format, $options) {
            $type = TypeStringDate::new(from: $obj);
            $type->getSetup()->_extra['format'] = $format;
            $type->addRule(Rules::date($format, $options->getErrorMessage()), $options);

            return $type;
        };
    }

    public static function everything(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) {

            return Type::new(from: $obj);
        };
    }

    public static function notFalsy(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = Type::new(from: $obj);
            $type->addRule(Rules::notFalsy($options->getErrorMessage() ?: RuleMessage::getErrorMessage('default.notFalsy')), $options);

            return $type;
        };
    }

    // public static function allowEmptyString()
    // {
    //     $type = new TypeUnkown();
    //     // TODO
    //     $type->allowEmptyString();
    //     return $type;
    // }
    // public static function allowNullTODO()
    // {
    //     $type = new TypeUnkown();
    //     $type->allowNull();
    //     return $type;
    // }
    public static function notNull(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) {

            return Type::new(from: $obj);
        };
    }

    public static function null(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeNull::new(from: $obj);
            $type->allowNull();
            $type->addRule(CoreRules::null($options->getErrorMessage() ?: RuleMessage::getErrorMessage('default.'.CoreRulesEnum::ID_NULL->value)), $options);

            return $type;
        };
    }

    public static function notEmptyString(bool $trim = false, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options, $trim) {
            $type = TypeString::new(from: $obj);
            $err = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('default.'.CoreRulesEnum::ID_NOT_EMPTY_STRING->value);
            $type->addRule(CoreRules::notEmptyString($trim, $err, $options));

            return $type;
        };
    }

    public static function emptyString(bool $trim = false, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options, $trim) {
            $type = TypeStringEmpty::new(from: $obj);
            $err = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('default.'.CoreRulesEnum::ID_EMPTY_STRING->value);
            $type->addRule(CoreRules::emptyString($trim, $err, $options));
            $type->allowEmptyString();

            return $type;
        };
    }

    public static function optional(mixed $default = null)
    {
        return function (?TypeInterface $obj) use ($default) {
            $type = Type::new(from: $obj);
            $type->removeRule(CoreRulesEnum::ID_REQUIRED->value);
            $type->setup->setRequired(false);
            if (count(func_get_args())) {
                $type->setup->setValueIfOptionalNotExists($default);
            }

            return $type;
        };
    }

    public static function undefined(bool $enableDafault = false, mixed $value = null, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($enableDafault, $value, $options) {
            $type = TypeUndefined::new(from: $obj);
            if (static::class === V::class) {
                $type->setup->_extra = ['startsWithUndefined' => true];
            }

            if ($enableDafault) {
                $type->_extra = ['default' => $value];
            }
            $type->addRule(CoreRules::undefined(), $options);

            return $type;
        };
    }

    public static function files(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) {

            return TypeFiles::new(from: $obj);
        };
    }

    public static function array(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeArray::new(from: $obj);
            $type->addRule(Rules::orderedIndexedArray($options->getErrorMessage()), $options);

            return $type;
        };
    }

    // public static function make($data, $setup = null, bool $stopOnFieldFailure = false, Options $options = null)
    // {
    //     $type = self::group($setup, $stopOnFieldFailure, $options);
    //     (new TypeProxy($type))->setData($data);

    //     return $type;
    // }

    // casts

    public static function asFile(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeFile::new(from: $obj);
            // as
            $type->addCallback(new Callback('asFile', fn () => null), $options);

            return $type;
        };
    }

    public static function asArray(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeArray::new(from: $obj);
            // as
            $type->addCallback(new Callback('asArray', fn () => null), $options);

            return $type;
        };
    }

    public static function asBool(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeBool::new(from: $obj);
            // as
            $type->addCallback(new Callback('asBool', fn () => null), $options);

            return $type;
        };
    }

    public static function asAny(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeAny::new(from: $obj);
            // as
            $type->addCallback(new Callback('asAny', fn () => null), $options);

            return $type;
        };
    }

    public static function asDate($format = 'Y-m-d', ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($format, $options) {
            $type = TypeStringDate::new(from: $obj);
            $type->addCallback(new Callback('asDate', fn () => null), $options);
            $type->getSetup()->_extra['format'] = $format;

            return $type;
        };
    }

    public static function asEmail(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeStringEmail::new(from: $obj);
            // as
            $type->addCallback(new Callback('asEmail', fn () => null), $options);

            return $type;
        };
    }

    public static function asScalar(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeScalar::new(from: $obj);
            // as
            $type->addCallback(new Callback('asScalar', fn () => null), $options);

            return $type;
        };
    }

    public static function asFloat(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeFloat::new(from: $obj);
            // as
            $type->addCallback(new Callback('asFloat', fn () => null), $options);

            return $type;
        };
    }

    public static function asGroup(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeGroup::new(from: $obj);
            // as
            $type->addCallback(new Callback('asGroup', fn () => null), $options);

            return $type;
        };
    }

    public static function asInt(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeInt::new(from: $obj);
            // as
            $type->addCallback(new Callback('asInt', fn () => null), $options);

            return $type;
        };
    }

    public static function asIntString(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeStringInt::new(from: $obj);
            // as
            $type->addCallback(new Callback('asIntString', fn () => null), $options);

            return $type;
        };
    }

    public static function asNumber(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeNumber::new(from: $obj);
            // as
            $type->addCallback(new Callback('asNumber', fn () => null), $options);

            return $type;
        };
    }

    public static function asString(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        return function (?TypeInterface $obj) use ($options) {
            $type = TypeString::new(from: $obj);
            // as
            $type->addCallback(new Callback('asString', fn () => null), $options);

            return $type;
        };
    }
}
