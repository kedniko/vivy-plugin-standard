<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Messages\TransformerMessage;
use Kedniko\Vivy\Support\Util;

final class TypeIntValue extends TypeNumber
{
    public function toInt(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('boolValueToBool');
        $transformer = Transformers::intValueToInt($errormessage);
        $this->addTransformer($transformer, $options);

        return TypeBool::new($this);
    }
}
