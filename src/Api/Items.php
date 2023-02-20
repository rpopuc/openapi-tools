<?php

namespace App\Api;

use ArrayAccess;
use Iterator;

/**
 * Classe que representa uma coleção de objetos de tipo genérico
 *
 * @template T
 */
class Items implements ArrayAccess, Iterator
{
    private array $items = [];
    private int $offset = 0;

    /**
     * Adiciona um item
     *
     * @param T $item
     */
    protected function addItem($item): int
    {
        $this->items[] = $item;

        return count($this->items) - 1;
    }

    public function offsetExists($offset): bool
    {
        return $this->offset >= 0
            && $this->offset < count($this->items);
    }

    /**
     * @param $offset
     * @return T
     */
    public function offsetGet($offset): mixed
    {
        return $this->items[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->items[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->items[$offset]);
    }

    /**
     * @return ?T
     */
    public function current(): mixed
    {
        return $this->valid()
            ?  $this->items[$this->offset]
            : null;
    }

    /**
     * @return ?T
     */
    public function next(): void
    {
        $this->offset++;
    }

    public function key(): int
    {
        return $this->offset;
    }

    public function valid(): bool
    {
        return count($this->items)
            && $this->offset >= 0
            && $this->offset < count($this->items);
    }

    public function rewind(): void
    {
        $this->offset = 0;
    }

    public function count(): int
    {
        return count($this->items);
    }
}
