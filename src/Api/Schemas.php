<?php

namespace App\Api;

/**
 * @extends Items<Schema>
 */
class Schemas extends Items
{
    public function add(Schema $item): int
    {
        return $this->addItem($item);
    }
}
