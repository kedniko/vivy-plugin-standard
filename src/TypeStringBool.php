<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Messages\TransformerMessage;
use Kedniko\Vivy\Support\Util;

final class TypeStringBool extends TypeString
{
    public function toBool(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('stringToBool');
        $transformer = Transformers::stringBoolToBool($errormessage);
        $this->addTransformer($transformer, $options);

        return TypeBool::new($this);
    }
}
