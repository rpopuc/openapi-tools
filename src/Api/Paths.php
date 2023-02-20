<?php

namespace App\Api;

/**
 * @extends Items<Path>
 */
class Paths extends Items
{
    public function add(Path $path): int
    {
        return $this->addItem($path);
    }
}
