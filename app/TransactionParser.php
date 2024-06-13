<?php

declare(strict_types=1);

namespace App;

use App\DTO\TransactionInfo;

class TransactionParser
{
    public function parse(string $str): TransactionInfo
    {
        $value = json_decode($str);
        return new TransactionInfo($value->bin, (float) $value->amount, $value->currency);
    }
}
