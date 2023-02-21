<?php

namespace App\Api;

/**
 * @extends Items<MediaType>
 */
class MediaTypes extends Items
{
    public function add(MediaType $item): int
    {
        return $this->addItem($item);
    }
}
