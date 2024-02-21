<?php

namespace Kedniko\Vivy\Plugin\Standard;

use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Messages\RuleMessage;

class Type extends \Kedniko\Vivy\Type
{
    // public function string(Options $options = null)
    // {
    // 	$options = Options::build($options, func_get_args());
    // 	$type = new TypeString();
    // 	$type->state = $caller->state; // share state
    // 	$type->addRule(Rules::string($options->getErrormessage()), $options);
    // 	return $type;
    // }

    public function equals(mixed $value, bool $strict = true, Options $options = null)
    {
        $options = Options::build($options, func_get_args());
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('valueNotAllowed');
        $this->addRule(Rules::equals($value, $strict, $errormessage), $options);

        return $this;
    }

    public function notEquals(mixed $value, bool $strict = true, Options $options = null)
    {
        $options = Options::build($options, func_get_args());
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('valueNotAllowed');
        $this->addRule(Rules::notEquals($value, $strict, $errormessage), $options);

        return $this;
    }

    public function allowNull()
    {
        $this->removeRule(Rules::ID_NOT_NULL);
        $this->state->setNotNull(false);

        return $this;
    }
}
