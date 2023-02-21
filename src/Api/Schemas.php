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

    public function getByName(string $name): ?Schema
    {
        foreach ($this as $schema) {
            if ($schema->getName() === $name) {
                return $schema;
            }
        }

        return null;
    }
}
