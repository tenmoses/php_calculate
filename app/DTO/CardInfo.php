<?php

declare(strict_types=1);

namespace App\DTO;

readonly class CardInfo
{
    private readonly bool $isEu;

    public function __construct($data)
    {
        $euCountries = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];
        $this->isEu = in_array($data['country']['alpha2'], $euCountries);
    }

    public function getIsEu(): bool
    {
        return $this->isEu;
    }
}
