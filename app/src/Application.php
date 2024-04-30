<?php

namespace Application;

use Application\Contracts\CommissionRatesServiceInterface;
use Application\Contracts\DataProviderInterface;
use Application\Services\CachedBinListNetResolver;
use Application\Services\ExchangeRatesApiService;

class Application
{
    public function __construct(
        public DataProviderInterface $dataProvider,
        public CachedBinListNetResolver $binListNetResolver,
        public CommissionRatesServiceInterface $ratesService,
        public ExchangeRatesApiService $exchangeRatesApiService,
    ) {
        $this->dataProvider->load();
    }

    /**
     * @throws \JsonException
     */
    public function run(): void
    {
        foreach ($this->dataProvider->getData() as $line) {
            //@todo: try catch

            $countryCode = $this->binListNetResolver->check($line['bin']);
            $rate = $this->exchangeRatesApiService->getExchangeRate("EUR", $line['currency']);
            echo $this->ratesService->calculate($line['currency'], $line['amount'], $rate, $countryCode) . "\n";
        }

    }
}


