<?php


namespace Tests\Unit;


use Application\Application;
use Application\Providers\InputFileProvider;
use Application\Services\CachedBinListNetResolver;
use Application\Services\CacheService;
use Application\Services\CommissionRatesService;
use Application\Services\ExchangeRatesApiService;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class ApplicationBaseTest extends Unit
{
    protected UnitTester $tester;

    public function testBaseInitApplication(): void
    {
        // @todo: add generating properly mocked class
        $dataProviderMock = $this->make(InputFileProvider::class, [
            'getData' => [
                [
                    "bin" => "45717360",
                    "amount" => "100.00",
                    "currency" => "EUR"
                ]
            ],
            'load' => Expected::exactly(1, static function () {
                return 1;
            }),
            'fileName' => "app.cache",
        ]);
        $exchangeRateMock = $this->construct(ExchangeRatesApiService::class, [
            "example of key",
            [
                'apiCall' => Expected::exactly(1, static function () {
                    return '{"base": "EUR","date": "2024-04-30","rates": {"USD": 1.072311},"success": true,"timestamp": 1714468864}';
                }),
            ],
        ]);

        $app = new Application(
            $dataProviderMock,
            new CachedBinListNetResolver(
                new CacheService()
            ),
            new CommissionRatesService(),
            $exchangeRateMock
        );

        $this->assertInstanceOf(Application::class, $app);
    }
}
