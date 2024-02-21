<?php

namespace Kedniko\Vivy\Plugin\Standard;

use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Core\Rule;
use Kedniko\Vivy\Messages\RuleMessage;

class TypeScalar extends \Kedniko\Vivy\Plugin\Standard\Type
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
        $this->removeRule(Rules::ID_NOT_EMPTY_STRING);
        $this->state->setNotEmptyString(false);

        return $this;
    }
}
