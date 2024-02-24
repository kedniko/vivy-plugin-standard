<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\Vivy\Contracts\TypeInterface;
use Kedniko\Vivy\Core\LinkedList;
use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Core\Rule;
use Kedniko\Vivy\Core\Validated;
use Kedniko\VivyPluginStandard\Enum\RulesEnum;
use Kedniko\Vivy\Support\Util;

final class TypeAnd extends Type
{
    /**
     * @param  TypeInterface[]  $types
     */
    public function __construct(array $types, $isNot = false, Options $options = null)
    {
        parent::__construct();
        $this->addRule($this->getAndRule($types, $isNot, $options->getErrorMessage()), $options);
        // $this->universes = $types;

        // $this->_extra['hasUndefined'] = false;
        // foreach ($types as $type) {

        // 	if (isset($type->state->_extra['startsWithUndefined']) && $type->state->_extra['startsWithUndefined']) {
        // 		$this->_extra['hasUndefined'] = true;
        // 	}
        // }
    }

    /**
     * @param  TypeInterface[]  $types
     * @param  bool  $isNot - true = all rule false. false = any rule true
     */
    private function getAndRule(array $types, $isNot, string $errormessage = null): Rule
    {
        $ruleID = RulesEnum::ID_AND->value;
        $types = new LinkedList($types);
        $ruleFn = function (ContextInterface $c) use (&$types, $isNot): bool|\Kedniko\Vivy\Core\Validated {
            $errors = [];

            $types->rewind();
            while ($types->hasNext()) {
                $type = $types->getNext();

                if (!$type instanceof TypeInterface) {
                    $type = new TypeAny();
                    $type->addRule(Rules::email());
                }

                $type->_extra = ['isInsideOr' => true];

                Util::clone($c->value);
                $validated = $type->validate($c->value, $c);
                $errors = $type->_extra['or_errors'] ?? [];
                if ($isNot) {
                    return false;
                }
                $c->value = $validated->value();
                $c->errors = [];
                break;
            }
            $types->rewind();

            return new Validated($c->value, $c->errors);
        };

        if ($isNot) {
            $errormessage = $errormessage ?: 'Errore: almeno un validatore ha avuto successo'; // TODO
        } else {
            $errormessage = $errormessage ?: 'Nessun validatore ha avuto successo'; // TODO
        }

        return new Rule($ruleID, $ruleFn, $errormessage);
    }
}
