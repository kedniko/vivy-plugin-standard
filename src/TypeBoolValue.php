<?php

namespace Kedniko\VivyPluginStandard;


use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Support\Util;
use Kedniko\Vivy\Messages\TransformerMessage;

final class TypeBoolValue extends TypeScalar
{
  public function toBool(Options $options = null)
  {
    $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
    $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('boolValueToBool');
    $transformer = Transformers::boolValueToBool($errormessage);
    $this->addTransformer($transformer, $options);

    return TypeBool::new($this);
  }
}
