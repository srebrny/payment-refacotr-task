<?php

require_once __DIR__ . "/vendor/autoload.php";

use Application\Application;
use Application\Providers\InputFileProvider;
use Application\Services\CachedBinListNetResolver;
use Application\Services\CacheService;
use Application\Services\CommissionRatesService;
use Application\Services\ExchangeRatesApiService;

$input = new InputFileProvider();
$input->setFileName($argv[1]);

try {
    (new Application(
        $input,
        new CachedBinListNetResolver(new CacheService()),
        new CommissionRatesService(),
        new ExchangeRatesApiService($_ENV['EXCHANGE_RATE_API_KEY'])
    ))->run();
} catch (JsonException $e) {
    echo $e->getMessage();
}
