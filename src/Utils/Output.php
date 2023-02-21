<?php

namespace App\Utils;

class Output
{
    private array $content = [];
    private int $identation = 0;

    public function up(): self
    {
        $this->identation++;
        return $this;
    }

    public function down(): self
    {
        $this->identation--;
        return $this;
    }

    public function reset(): self
    {
        $this->identation = 0;
        return $this;
    }

    public function add(string $message): self
    {
        $this->content[] = $this->getIdentation() . $message;
        return $this;
    }

    private function getIdentation(): string
    {
        return str_pad('', $this->identation * 2, ' ');
    }

    public function join(string $glue = PHP_EOL): string
    {
        return implode($glue, $this->content);
    }
}
