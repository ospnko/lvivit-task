<?php

declare(strict_types=1);

namespace App\Utils;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationErrors
{
    public function __construct(
        private ConstraintViolationListInterface $errors,
    ) {
    }

    public function hasErrors(): bool
    {
        return $this->errors->count() > 0;
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->errors as $error) {
            $result[$error->getPropertyPath()] = $error->getMessage();
        }

        return $result;
    }
}
