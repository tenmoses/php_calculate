<?php

declare(strict_types=1);

namespace App\Service;

use Exception;
use App\DTO\CardInfo;

class CardChecker
{
    public function __construct(private readonly string $url)
    {
    }

    public function getCardInfo(string $bin): CardInfo
    {
        $data = json_decode(file_get_contents($this->url), true);

        if (array_key_exists($bin, $data)) {
            return new CardInfo($data[$bin]);
        } else {
            throw new Exception(sprintf('Cannot find info for card %s', $bin));
        }
    }
}
