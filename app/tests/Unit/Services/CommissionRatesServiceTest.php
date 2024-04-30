<?php

namespace Unit\Services;

use Application\Services\CommissionRatesService;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use PHPUnit\Framework\TestCase;
use Tests\Support\UnitTester;

class CommissionRatesServiceTest extends TestCase
{
    protected UnitTester $tester;

    /**
     * @param Example $example
     *
     * @dataProvider defaultInputFile
     * @return void
     */
    public function testCalculateCommissionRateForDefaultFile($expected, $currency, $amount, $rate, $country): void
    {

        $this->assertEquals(
            $expected,
            (new CommissionRatesService())->calculate($currency, $amount, $rate, $country));
    }

    protected function defaultInputFile(): array
    {
        return [
            [
                'expected' => "1",
                'currency' => "EUR",
                'amount' => 100,
                'rate' => 0,
                'country' => "DK"
            ],
            [
                'expected' => "0.46180844185832",
                'currency' => "USD",
                'amount' => 50.00,
                'rate' => 1.072311,
                'country' => "LT"
            ],
            [
                'expected' => "1.6574127786525",
                'currency' => "JPY",
                'amount' => 10000.00,
                'rate' => 0,
                'country' => "JP"
            ],
            [
                'expected' => "2.4014038976632",
                'currency' => "USD",
                'amount' => 130.00,
                'rate' => 0,
                'country' => "US"
            ],
            [
                'expected' => "43.714413735069",
                'currency' => "GBP",
                'amount' => 2000.00,
                'rate' => 0,
                'country' => "LT"
            ]
        ];
    }

    public function testIsEu()
    {
        $crs = new CommissionRatesService();
        $this->assertTrue($crs->isEu("DK"));
        $this->assertTrue($crs->isEu("PO"));
        $this->assertTrue($crs->isEu("DE"));
        $this->assertFalse($crs->isEu("US"));
        $this->assertFalse($crs->isEu("UZ"));
        $this->assertFalse($crs->isEu("ZW"));
    }
}
