<?php

namespace Kedniko\Vivy\Plugin\Standard;

use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\Vivy\Exceptions\VivyTransformerException;
use Kedniko\Vivy\Messages\TransformerMessage;
use Kedniko\Vivy\Transformer;

final class TypeInt extends TypeNumber
{
    /**
     * @var string
     */
    private const TRANSFORMER_ID = 'intToBool';

    public function toBool($strict = true, $errormessage = null)
    {
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage('intToBool');

        $this->addRule(Rules::intBool($strict));

        $type = (new TypeBool())->from($this);
        $errormessage = $errormessage ?: TransformerMessage::getErrorMessage(self::TRANSFORMER_ID);
        $transformer = new Transformer(self::TRANSFORMER_ID, function (ContextInterface $c) use ($strict): bool {
            $value = $c->value;

            if (!is_int($value)) {
                throw new VivyTransformerException();
            }

            if ($strict && !in_array($value, [0, 1], true)) {
                throw new VivyTransformerException();
            }

            if ($strict) {
                return $value === 1;
            }

            return (bool) $value;
        }, $errormessage);

        $type->addTransformer($transformer);

        return $type;
    }
}
