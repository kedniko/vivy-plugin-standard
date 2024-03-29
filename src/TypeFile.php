<?php

namespace Kedniko\VivyPluginStandard;

use Kedniko\Vivy\Contracts\ContextInterface;
use Kedniko\Vivy\Core\Options;
use Kedniko\Vivy\Core\Rule;
use Kedniko\Vivy\Support\Util;
use Kedniko\Vivy\Type\TypeCompound;

final class TypeFile extends TypeCompound
{
    public const MIME_PDF = 'application/pdf';

    /**
     * @var string[]
     */
    private const UNITS = ['B', 'KB', 'MB', 'GB'];

    public function mime($mime, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Mime non corretto';

        $middleware = new Rule('mime', function (ContextInterface $c) use ($mime): bool {
            $valueMime = $c->value['type'];

            return $valueMime === $mime;
        }, $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function pdf(?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Non è un pdf';

        $middleware = new Rule('pdf', function (ContextInterface $c): bool {
            $valueMime = $c->value['type'];

            return $valueMime === self::MIME_PDF;
        }, $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    /**
     * @param  array  $extensions
     */
    public function extensionIn($extensions, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Estensione non corretta';

        $middleware = new Rule('extension', fn (ContextInterface $c): bool => in_array(pathinfo((string) $c->value['tmp_name'], PATHINFO_EXTENSION), $extensions), $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function extension($extension, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Estensione non corretta';

        $middleware = new Rule('extension', fn (ContextInterface $c): bool => $extension === pathinfo((string) $c->value['tmp_name'], PATHINFO_EXTENSION), $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function baseNameEquals($basename, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Lunghezza basename non valida';

        $middleware = new Rule('baseNameEquals', fn (ContextInterface $c): bool => $basename === pathinfo((string) $c->value['basename'], PATHINFO_BASENAME), $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function baseNameLength($maxLength, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Lunghezza basename non valida';

        $middleware = new Rule('baseNameLength', fn (ContextInterface $c): bool => $maxLength === strlen(pathinfo((string) $c->value['basename'], PATHINFO_BASENAME)), $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function baseNameMinLength($maxLength, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Basename troppo corto';

        $middleware = new Rule('baseNameMinLength', fn (ContextInterface $c): bool => $maxLength >= strlen(pathinfo((string) $c->value['basename'], PATHINFO_BASENAME)), $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function baseNameMaxLength($maxLength, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Basename troppo lungo';

        $middleware = new Rule('baseNameMaxLength', fn (ContextInterface $c): bool => $maxLength <= strlen(pathinfo((string) $c->value['basename'], PATHINFO_BASENAME)), $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function fileNameLength($maxLength, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Lunghezza filename non valida';

        $middleware = new Rule('FileNameLength', fn (ContextInterface $c): bool => $maxLength === strlen(pathinfo((string) $c->value['FILENAME'], PATHINFO_FILENAME)), $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function fileNameMinLength($maxLength, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Filename troppo corto';

        $middleware = new Rule('fileNameMinLength', fn (ContextInterface $c): bool => $maxLength >= strlen(pathinfo((string) $c->value['FILENAME'], PATHINFO_FILENAME)), $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function fileNameMaxLength($maxLength, ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Filename troppo lungo';

        $middleware = new Rule('fileNameMaxLength', fn (ContextInterface $c): bool => $maxLength <= strlen(pathinfo((string) $c->value['FILENAME'], PATHINFO_FILENAME)), $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function size(mixed $size, mixed $unit = 'B', ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Dimensione file non accettata';

        $size = $this->convertUnit($size, $unit, 'B');

        $middleware = new Rule('size', function (ContextInterface $c) use ($size): bool {
            $valueSize = $c->value['size'];

            return (float) $valueSize === (float) $size;
        }, $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    /**
     * @param  string  $unit  `B` | `KB` | `MB` | `GB`,
     */
    public function maxSize(mixed $maxSize, mixed $unit = 'B', ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Dimensione file troppo grande';

        $maxSize = $this->convertUnit($maxSize, $unit, 'B');

        $middleware = new Rule('maxSize', function (ContextInterface $c) use ($maxSize): bool {
            $valueSize = $c->value['size'];

            return $valueSize <= $maxSize;
        }, $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    public function minSize(mixed $minSize, mixed $unit = 'B', ?Options $options = null)
    {
        $options = Options::build($options, Util::getRuleArgs(__METHOD__, func_get_args()), __METHOD__);
        $errormessage = $options->getErrorMessage() ?: 'Dimensione file troppo piccola';

        $minSize = $this->convertUnit($minSize, $unit, 'B');

        $middleware = new Rule('minSize', function (ContextInterface $c) use ($minSize): bool {
            $valueSize = $c->value['size'];

            return $valueSize >= $minSize;
        }, $errormessage);

        $this->addRule($middleware, $options);

        return $this;
    }

    /**
     * @param  mixed  $from  `B`|`KB`|`MB`|`GB`
     * @param  mixed  $to  `B`|`KB`|`MB`|`GB`
     */
    private function convertUnit(mixed $value, mixed $from, string $to): int|float
    {
        $from = strtoupper((string) $from);
        $to = strtoupper($to);
        $value = (float) $value;
        $index = array_search($from, self::UNITS);
        $toIndex = array_search($to, self::UNITS);
        $diff = $toIndex - $index;
        if ($diff === 0) {
            return $value;
        }
        if ($diff > 0) {
            for ($i = 0; $i < $diff; $i++) {
                $value /= 1024;
            }
        } else {
            for ($i = 0; $i < abs($diff); $i++) {
                $value *= 1024;
            }
        }

        return $value;
    }
}
