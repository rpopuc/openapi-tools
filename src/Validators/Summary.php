<?php

namespace App\Validators;

class Summary
{
    private array $errors = [];

    public function addError(string $message): self
    {
        $this->errors[] = $message;

        return $this;
    }

    public function isValid(): bool
    {
        return count($this->errors) === 0;
    }

    public function getErrors(): array
    {
        return array_values($this->errors);
    }

    public function merge(Summary $summary): Summary
    {
        foreach ($summary->getErrors() as $error) {
            $this->addError($error);
        }

        return $this;
    }
}
