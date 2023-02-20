<?php

namespace App\Api;

use ArrayAccess;
use Iterator;

/**
 * @extends Items<Parameter>
 */
class Parameters extends Items
{
    public function add(Parameter $parameter): int
    {
        return $this->addItem($parameter);
    }
}
