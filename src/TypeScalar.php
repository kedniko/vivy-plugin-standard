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
    public function in(array $array, bool $strict = true, Options $options = null)
    {
        $options = Options::build($options, func_get_args());
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('valuesNotAllowed');
        $this->addRule(Rules::inArray($array, $strict, $errormessage), $options);

        return $this;
    }

    public function notIn(array $array, bool $strict = true, Options $options = null)
    {
        $options = Options::build($options, func_get_args());
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('valuesNotAllowed');
        $this->addRule(Rules::notInArray($array, $strict, $errormessage), $options);

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

        $this->addRule(Rules::regex($regex, $ruleID, $errormessage), $options);

        return $this;
    }

    public function notRegex($regex, $ruleID, Options $options = null)
    {
        $options = Options::build($options, func_get_args());
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('notRegex');

        $this->addRule(Rules::notRegex($regex, $ruleID, $errormessage), $options);

        return $this;
    }

    public function allowEmptyString()
    {
        $this->removeRule(RulesEnum::ID_NOT_EMPTY_STRING->value);
        $this->state->setNotEmptyString(false);

        return $this;
    }
}
