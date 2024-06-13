<?php

declare(strict_types=1);

namespace App\Service;

use Exception;

class ExchangeRate
{
    /**
     * @var float[] $rates
     */
    private array $rates;

    public function __construct(string $url)
    {
        $this->rates = json_decode(file_get_contents($url), true);
    }

    public function getRate(string $currency, string $baseCurrency): float
    {

        if (array_key_exists($currency, $this->rates)) {
            return $this->rates[$currency];
        } else {
            throw new Exception(sprintf('Cannot get rates for currency %s', $currency));
        }
    }
}
