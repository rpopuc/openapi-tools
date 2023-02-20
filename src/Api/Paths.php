<?php

namespace App\Api;

use ArrayAccess;
use Iterator;

class Paths implements ArrayAccess, Iterator
{
    private array $paths = [];
    private int $offset = 0;

    public function add(Path $path): int
    {
        $this->paths[] = $path;

        return count($this->paths) - 1;
    }

    public function offsetExists($offset): bool
    {
        return $this->offset >= 0
            && $this->offset < count($this->paths);
    }

    public function offsetGet($offset): Path
    {
        return $this->paths[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        $this->paths[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->paths[$offset]);
    }

    public function current(): ?Path
    {
        return $this->valid()
            ?  $this->paths[$this->offset]
            : null;
    }

    public function next(): ?Path
    {
        $this->offset++;

        return $this->current();
    }

    public function key(): int
    {
        return $this->offset;
    }

    public function valid(): bool
    {
        return $this->offset >= 0
            && $this->offset < count($this->paths);
    }

    public function rewind(): void
    {
        $this->offset = 0;
    }
}
