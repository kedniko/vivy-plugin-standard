<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Support\Util;
use Kedniko\Vivy\Type as CoreType;
use Kedniko\Vivy\Messages\RuleMessage;
use Kedniko\VivyPluginStandard\Enum\RulesEnum;

class Type extends CoreType
{

    public function equals(mixed $value, bool $strict = true, Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('valueNotAllowed');
        $this->addRule(Rules::equals($value, $strict, $errormessage), $options);

        return $this;
    }

    public function notEquals(mixed $value, bool $strict = true, Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('valueNotAllowed');
        $this->addRule(Rules::notEquals($value, $strict, $errormessage), $options);

        return $this;
    }

    public function allowNull()
    {
        $this->removeRule(RulesEnum::ID_NOT_NULL->value);
        $this->state->setNotNull(false);

        return $this;
    }
}
