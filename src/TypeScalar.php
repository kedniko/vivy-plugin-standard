<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Core\Rule;
use Kedniko\Vivy\Core\Options;
use Kedniko\VivyPluginStandard\Type;
use Kedniko\Vivy\Messages\RuleMessage;
use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\VivyPluginStandard\Enum\RulesEnum;

class TypeScalar extends Type
{
    public function in(array $array, Options $options = null)
    {
        $options = Options::build($options, func_get_args());
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('valuesNotAllowed');
        $this->addRule(Rules::in($array, $errormessage), $options);

        return $this;
    }

    public function notInArray(array $array, Options $options = null)
    {
        $options = Options::build($options, func_get_args());
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('valuesNotAllowed');
        $this->addRule(Rules::notInArray($array, $errormessage), $options);

        return $this;
    }

    // public function transform(Transformer $transformer)
    // {
    // 	if ($transformer) {
    // 		$this->addTransformer($transformer);
    // 	}
    // 	return $this;
    // }

    public function regex($regex, $ruleID, Options $options = null)
    {
        $options = Options::build($options, func_get_args());
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('regex');
        $rule = new Rule($ruleID, function (ContextInterface $c) use ($regex): bool {
            if (!$c->value) {
                return false;
            }
            if (!is_string($c->value)) {
                return false;
            }

            return preg_match($regex, $c->value, $matches) === 1;
        }, $errormessage);

        $this->addRule($rule, $options);

        return $this;
    }

    public function notRegex($regex, $ruleID, Options $options = null)
    {
        $options = Options::build($options, func_get_args());
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('regex');
        $rule = new Rule($ruleID, function (ContextInterface $c) use ($regex): bool {
            if (!$c->value) {
                return false;
            }
            if (!is_string($c->value)) {
                return false;
            }

            return preg_match($regex, $c->value, $matches) !== 1;
        }, $errormessage);

        $this->addRule($rule, $options);

        return $this;
    }

    public function allowEmptyString()
    {
        $this->removeRule(RulesEnum::ID_NOT_EMPTY_STRING->value);
        $this->state->setNotEmptyString(false);

        return $this;
    }
}
