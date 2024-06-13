<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Calculator;
use App\Service\CardChecker;
use App\Service\CommissionRate;
use App\Service\ExchangeRate;
use App\TransactionParser;

$exchangeRateUrl = 'https://raw.githubusercontent.com/tenmoses/php_calculate/main/rates.json';
$lookupsUrl = 'https://raw.githubusercontent.com/tenmoses/php_calculate/main/lookups.json';
$baseCurrency = 'EUR';

$transationParser = new TransactionParser();
$exchangeRateService = new ExchangeRate($exchangeRateUrl);
$cardChecker = new CardChecker($lookupsUrl);
$comissionRate = new CommissionRate(['eu' => 0.01, 'other' => 0.02]);

$calculator = new Calculator(
    $transationParser,
    $exchangeRateService,
    $cardChecker,
    $comissionRate,
    $baseCurrency
);

foreach (explode("\n", file_get_contents($argv[1])) as $row) {
    if (empty($row)) {
        break;
    }

    try {
        echo $calculator->calculate($row);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    print "\n";
}
