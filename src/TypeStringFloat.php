<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Messages\TransformerMessage;
use Kedniko\Vivy\Support\Util;

final class TypeStringFloat extends TypeStringNumber
{
    public function toFloat(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('stringToInt');

        $transformer = Transformers::stringNumberToFloat($errormessage);
        $this->addTransformer($transformer, $options);

        return TypeFloat::new($this);
    }

    public function toInteger(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('stringToInt');

        if (! $this->getSetup()->hasRule('intString')) {
            $this->addRule(Rules::intString($options->getErrorMessage()), $options);
        }

        $transformer = Transformers::stringNumberToInt($errormessage);
        $this->addTransformer($transformer, $options);

        return TypeInt::new($this);
    }
}
