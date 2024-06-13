<?php

declare(strict_types=1);

namespace App\DTO;

readonly class TransactionInfo
{
    public function __construct(
        private readonly string $bin,
        private readonly float $amount,
        private readonly string $currency
    ) {
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getFixedAmount(float $rate): float
    {
        if ($this->currency === 'EUR') {
            return $this->amount;
        }

        if ($rate === 0.0) {
            return $this->amount;
        }

        return $this->amount / $rate;
    }
}
