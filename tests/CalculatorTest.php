<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use App\TransactionParser;
use App\Service\ExchangeRate;
use App\Service\CardChecker;
use App\Calculator;
use App\DTO\CardInfo;
use App\Service\CommissionRate;

final class CalculatorTest extends TestCase
{
    public static function transationProvider(): array
    {
        return [
            [
                '{"bin":"45717360","amount":"100.00","currency":"EUR"}',
                0,
                "45717360" => ["country" => ["alpha2" => "DK"]],
                1.0
            ],
            [
                '{"bin":"516793","amount":"50.00","currency":"USD"}',
                1.08,
                ["country" => ["alpha2" => "LT"]],
                0.47
            ],
            [
                '{"bin":"45417360","amount":"10000.00","currency":"JPY"}',
                168.99,
                ["country" => ["alpha2" => "JP"]],
                1.19
            ],
            [
                '{"bin":"41417360","amount":"130.00","currency":"USD"}',
                1.08,
                ["country" => ["alpha2" => "US"]],
                2.41
            ],
            [
                '{"bin":"4745030","amount":"2000.00","currency":"GBP"}',
                0.84,
                ["country" => ["alpha2" => "LT"]],
                23.81
            ],
        ];
    }

    #[DataProvider('transationProvider')]
    public function testWithValues(string $transaciton, float $rate, array $cardInfo, float $expected): void
    {
        $transationParser = new TransactionParser();
        $exchangeRateService = $this->createMock(ExchangeRate::class);
        $exchangeRateService->method('getRate')->willReturn($rate);
        $cardChecker = $this->createMock(CardChecker::class);
        $cardChecker->method('getCardInfo')->willReturn(new CardInfo($cardInfo));
        $comissionRate = new CommissionRate(['eu' => 0.01, 'other' => 0.02]);

        $result = (new Calculator(
            $transationParser,
            $exchangeRateService,
            $cardChecker,
            $comissionRate,
            'EUR'
        ))->calculate($transaciton);

        $this->assertSame($expected, $result);
    }
}
