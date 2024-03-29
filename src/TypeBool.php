<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Core\Rule;
use Kedniko\Vivy\Messages\RuleMessage;
use Kedniko\Vivy\Messages\TransformerMessage;
use Kedniko\Vivy\Rules as CoreRules;
use Kedniko\Vivy\Support\Util;
use Kedniko\VivyPluginStandard\Enum\RulesEnum;
use Kedniko\VivyPluginStandard\Enum\TransformersEnum;

final class TypeBool extends TypeScalar
{
    public function equals($bool, $strict = true, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('bool.is');
        $this->addRule(self::ruleBooleanIs($bool, $errormessage), $options);

        return $this;
    }

    public function isTrue(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('bool.isTrue');
        $rule = new Rule('bool-is-true', fn (ContextInterface $c): bool => $c->value === true, $errormessage);

        $this->addRule($rule, $options);

        return $this;
    }

    public function isFalse(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('bool.isFalse');
        $rule = new Rule('bool-is-false', fn (ContextInterface $c): bool => $c->value === false, $errormessage);

        $this->addRule($rule, $options);

        return $this;
    }

    // Rules

    private static function ruleBooleanIs($bool, $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_BOOL_IS->value;
        $ruleFn = fn (ContextInterface $c): bool => $c->value === $bool;

        $errormessage = $errormessage ?: RuleMessage::getErrorMessage("default.{$ruleID}");

        return new Rule($ruleID, $ruleFn, $errormessage);
    }

    public function toInteger(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('boolToInt');

        $ruleID = TransformersEnum::ID_BOOL_TO_INT->value;
        $type = TypeInt::new($this);
        $type->required($errormessage ?: RuleMessage::getErrorMessage("{$ruleID}.required"));
        $type->addRule(CoreRules::notNull($errormessage ?: RuleMessage::getErrorMessage("{$ruleID}.notNull")));
        $type->addRule(CoreRules::notEmptyString($errormessage ?: RuleMessage::getErrorMessage("{$ruleID}.notEmptyString")));
        $type->addRule(Rules::int($errormessage ?: RuleMessage::getErrorMessage("{$ruleID}.type")), $options);
        $type->addTransformer(Transformers::boolToInt($errormessage), $options);

        return $type;
    }

    public function toString(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('boolToInt');

        $ruleID = TransformersEnum::ID_BOOL_TO_STRING->value;
        $type = TypeString::new($this);
        $type->required($errormessage ?: RuleMessage::getErrorMessage("{$ruleID}.required"));
        $type->addRule(CoreRules::notNull($errormessage ?: RuleMessage::getErrorMessage("{$ruleID}.notNull")));
        $type->addRule(CoreRules::notEmptyString($errormessage ?: RuleMessage::getErrorMessage("{$ruleID}.notEmptyString")));
        $type->addRule(Rules::bool($errormessage ?: RuleMessage::getErrorMessage("{$ruleID}.type")), $options);
        $type->addTransformer(Transformers::boolToString($errormessage), $options);

        return $type;
    }
}
