<?php

declare(strict_types=1);

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\Vivy\Core\Helpers;
use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Messages\RuleMessage;
use Kedniko\Vivy\Messages\TransformerMessage;
use Kedniko\Vivy\Support\Util;
use Kedniko\Vivy\Transformer;

class TypeString extends TypeScalar
{
    public function prefix($string, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('string.prefix');
        $transformer = new Transformer('prefix', function (ContextInterface $c): string {
            $prefix = Helpers::issetOrDefault($c->args()[0], '');

            return $prefix.$c->value;
        }, $errormessage);

        $this->addTransformer($transformer, $options);

        return $this;
    }

    public function trim($characters = " \t\n\r\0\x0B", ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('trim');
        $this->addTransformer(Transformers::trim($characters, $errormessage), $options);

        return $this;
    }

    public function ltrim($characters, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('ltrim');
        $this->addTransformer(Transformers::ltrim($characters, $errormessage), $options);

        return $this;
    }

    public function rtrim($characters, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('rtrim');
        $this->addTransformer(Transformers::rtrim($characters, $errormessage), $options);

        return $this;
    }

    public function toUppercase(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('toUpperCase');
        $this->addTransformer(Transformers::toUpperCase($errormessage), $options);

        return $this;
    }

    public function toUpperCaseFirstLetter(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('upperCaseFirstLetter');
        $this->addTransformer(Transformers::upperCaseFirstLetter($errormessage), $options);

        return $this;
    }

    public function toUpperCaseFirstLetterEachWord($separators = " \t\r\n\f\v", ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('upperCaseFirstLetterEachWord');
        $this->addTransformer(Transformers::upperCaseFirstLetterEachWord($separators, $errormessage), $options);

        return $this;
    }

    public function toLowercase(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('toLowerCase');
        $this->addTransformer(Transformers::toLowerCase($errormessage), $options);

        return $this;
    }

    public function toLowerCaseFirstLetter(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('lowerCaseFirstLetter');
        $this->addTransformer(Transformers::lowerCaseFirstLetter($errormessage), $options);

        return $this;
    }

    public function toReplace(array|string $search, array|string $replace, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: TransformerMessage::getErrorMessage('toLowerCase');
        $this->addTransformer(Transformers::toReplace($search, $replace, $errormessage), $options);

        return $this;
    }

    public function startsWith(string $startsWith, $ignoreCase = true, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('string.startsWith');
        $this->addRule(Rules::stringStartsWith($startsWith, $ignoreCase = true, $errormessage), $options);

        return $this;
    }

    public function endsWith(string $endsWith, $ignoreCase = true, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('string.endsWith');
        $this->addRule(Rules::ruleEndsWith($endsWith, $ignoreCase = true, $errormessage), $options);

        return $this;
    }

    public function contains(string $contains, $ignoreCase = true, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('string.contains');
        $this->addRule(Rules::ruleContains($contains, $ignoreCase = true, $errormessage), $options);

        return $this;
    }

    public function length(int $length, ?Options $options = null)
    {
        if ($length < 0) {
            throw new \InvalidArgumentException('Length must be greater than or equal to 0');
        }

        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('string.length');
        $this->addRule(Rules::stringLength($length, $errormessage), $options);

        return $this;
    }

    public function minLength(int $length, ?Options $options = null)
    {
        if ($length < 0) {
            throw new \InvalidArgumentException('Length must be greater than or equal to 0');
        }

        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('string.minLength');
        $this->addRule(Rules::stringMinLength($length, $errormessage), $options);

        return $this;
    }

    public function maxLength(int $length, ?Options $options = null)
    {
        if ($length < 0) {
            throw new \InvalidArgumentException('Length must be greater than or equal to 0');
        }

        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('string.maxLength');
        $this->addRule(Rules::stringMaxLength($length, $errormessage), $options);

        return $this;
    }

    public function intString(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('intString.type');
        $this->addRule(Rules::intString($errormessage), $options);

        return TypeStringInt::new($this);
    }

    public function bool(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('boolString.type');
        $this->addRule(Rules::boolString($errormessage), $options);

        return TypeStringBool::new($this);
    }

    public function email(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);

        $errormessage = $options->getErrorMessage() ?: RuleMessage::getErrorMessage('email.type');
        $this->addRule(Rules::email($errormessage), $options);

        return TypeStringEmail::new($this);
    }

    // Rules

    // private static function ruleIntString($errormessage = null)
    // {
    //     $ruleID = Rules::ID_INT_STRING;
    //     $ruleFn = function (Context $c) {
    //         if (!is_string($c->value)) {
    //             return false;
    //         }

    //         $value = trim(strval($c->value));

    //         // accept negative integers
    //         $shouldRemoveFirstCharacter = substr($value, 0, 1) === '-';
    //         if ($shouldRemoveFirstCharacter) {
    //             $value = substr($value, 1);
    //         }

    //         $isTypeIntString = ctype_digit($value);
    //         return $isTypeIntString;
    //     };

    //     $errormessage = $errormessage ?: RuleMessage::getErrorMessage("default.{$ruleID}");

    //     return new Rule($ruleID, $ruleFn, $errormessage);
    // }
}
