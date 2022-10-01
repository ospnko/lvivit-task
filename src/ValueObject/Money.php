<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Enum\Currency;

class Money
{
    public function __construct(
        public readonly float $amount,
        public readonly Currency $currency,
    ) {
    }

    public static function fromArray(array $array): self
    {
        return new Money(
            $array['amout'],
            Currency::from($array['curreny']),
        );
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency->value,
        ];
    }
}
