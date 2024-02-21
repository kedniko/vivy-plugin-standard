<?php

namespace Kedniko\Vivy\Plugin\Standard;

use Kedniko\Vivy\Concerns\Typeable;
use Kedniko\Vivy\Contracts\TypeContract;

final class TypeAny extends Type implements TypeContract
{
    use Typeable;
}
