<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\CardInfo;

class CommissionRate
{
    public function __construct(private array $rates)
    {
    }

    public function getByCardInfo(CardInfo $cardInfo): float
    {
        return $cardInfo->getIsEu() ? $this->rates['eu'] : $this->rates['other'];
    }
}
