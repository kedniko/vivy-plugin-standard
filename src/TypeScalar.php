<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Enum\RulesEnum as CoreRulesEnum;
use Kedniko\Vivy\Messages\RuleMessage;
use Kedniko\Vivy\Support\Util;

class TypeScalar extends Type
{
    public function in(array $array, bool $strict = true, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('valuesNotAllowed');
        $this->addRule(Rules::inArray($array, $strict, $errormessage), $options);

        return $this;
    }


    public function notIn(array $array, bool $strict = true, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
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

    public function regex($regex, $ruleID, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage($ruleID);

        $this->addRule(Rules::regex($regex, $ruleID, $errormessage), $options);

        return $this;
    }

    public function notRegex($regex, $ruleID, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('notRegex');

        $this->addRule(Rules::notRegex($regex, $ruleID, $errormessage), $options);

        return $this;
    }
}
