<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\Vivy\Core\Helpers;
use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Support\Util;
use Kedniko\Vivy\V;

final class TypeStringEmail extends TypeString
{
    public function checkValidDomain($record = 'MX', ?Options $options = null)
    {
        $record = Helpers::notNullOrDefault($record, 'MX');
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Questo dominio non esiste';

        $rule = V::rule('domain-exists', function (ContextInterface $c) use ($record): bool {
            $email = $c->value ?: '';
            $domain = explode('@', $email)[1];

            return checkdnsrr($domain, $record);
        }, $errormessage);

        $this->addRule($rule, $options);

        return $this;
    }

    public function domainIs($domain, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Il dominio non corrisponde';

        $rule = V::rule('invalid-domain', function (ContextInterface $c) use ($domain): bool {
            $email = $c->value ?: '';
            $valuedomain = explode('@', $email)[1];

            return $domain === $valuedomain;
        }, $errormessage);

        $this->addRule($rule, $options);

        return $this;
    }

    public function domainInArray($domainArray, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Il dominio non corrisponde';

        $rule = V::rule('invalid-domain', function (ContextInterface $c) use ($domainArray): bool {
            $email = $c->value ?: '';
            $valuedomain = explode('@', $email)[1];

            return in_array($valuedomain, $domainArray, true);
        }, $errormessage);

        $this->addRule($rule, $options);

        return $this;
    }

    public function tldIs($tld, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Il Top-level-domain non valido';

        $rule = V::rule('invalid-domain', function (ContextInterface $c) use ($tld): bool {
            $email = $c->value ?: '';
            $tldvalue = explode('.', explode('@', $email)[1])[1];

            return $tld === $tldvalue;
        }, $errormessage);

        $this->addRule($rule, $options);

        return $this;
    }

    public function tldInArray($tldArray, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Il Top-level-domain non valido';

        $rule = V::rule('invalid-domain', function (ContextInterface $c) use ($tldArray): bool {
            $email = $c->value ?: '';
            $tldvalue = explode('.', explode('@', $email)[1])[1];

            return in_array($tldvalue, $tldArray, true);
        }, $errormessage);

        $this->addRule($rule, $options);

        return $this;
    }
}
