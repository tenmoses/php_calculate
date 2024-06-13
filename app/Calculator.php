<?php

namespace App;

use App\Service\ExchangeRate;
use App\Service\CardChecker;
use App\Service\CommissionRate;

class Calculator
{
    public function __construct(
        private TransactionParser $transactionParser,
        private ExchangeRate $exchangeRateService,
        private CardChecker $cardChecker,
        private CommissionRate $commissionRate,
        private readonly string $baseCurrency,
    ) {
    }

    public function calculate(string $transactionString): float
    {
        $transaction = $this->transactionParser->parse($transactionString);

        $rate = $this->exchangeRateService->getRate($transaction->getCurrency(), $this->baseCurrency);

        $cardInfo = $this->cardChecker->getCardInfo($transaction->getBin());

        $result = $transaction->getFixedAmount($rate) * $this->commissionRate->getByCardInfo($cardInfo);

        return ceil(round($result, 3) * 100) / 100;
    }
}
