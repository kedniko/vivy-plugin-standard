<?php

namespace Kedniko\Vivy\Plugin\Standard;

use Kedniko\Vivy\Core\Helpers;
use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Messages\TransformerMessage;

final class TypeStringBool extends TypeString
{
    public function toBool(Options $options = null)
    {
        $options = Helpers::getOptions($options);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('stringToBool');
        $transformer = Transformers::stringBoolToBool($errormessage);
        $this->addTransformer($transformer, $options);

        return (new TypeBool())->from($this);
    }
}
