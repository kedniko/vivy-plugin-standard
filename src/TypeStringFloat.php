<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Core\Helpers;
use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Messages\TransformerMessage;
use Kedniko\Vivy\Support\TypeProxy;

final class TypeStringFloat extends TypeStringNumber
{
    // public function toInteger(Options $options = null)
    // {
    //     $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
    //     $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('stringToInt');

    //     if (!(new TypeProxy($this))->hasRule('intString')) {
    //         $this->addRule(Rules::intString($options->getErrorMessage()), $options);
    //     }

    //     $transformer = Transformers::stringToInt($errormessage);
    //     $this->addTransformer($transformer, $options);

    //     return TypeInt::new($this);
    // }
}
