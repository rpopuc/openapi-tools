<?php

namespace App\Api;

/**
 * @extends Items<Operation>
 */
class Operations extends Items
{
    public function add(Operation $item): int
    {
        return $this->addItem($item);
    }
}
