<?php

namespace App\Api;

/**
 * @extends Items<Property>
 */
class Properties extends Items
{
    public function add(Property $property): int
    {
        return $this->addItem($property);
    }
}
