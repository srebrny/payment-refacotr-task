<?php

namespace Unit\Services;

use Application\Services\CachedBinListNetResolver;
use Application\Services\CacheService;
use Codeception\Stub\Expected;
use Codeception\Test\Unit;

class CachedBinListNetResolverTest extends Unit
{
    public function testCachedBinListNetResolver(): void
    {
        $cacheMock = $this->make(CacheService::class,
            [
                'cached' => ["45717360" => "DK"]
            ]
        );

        $bin = "45717360";
        $binListNetResolver = $this->construct(
            CachedBinListNetResolver::class,
            ['cache' => $cacheMock],
            [
                'callBinService' =>Expected::atLeastOnce(function() { return "PL"; })
            ]
        );

        $this->assertEquals("DK", $binListNetResolver->check($bin));
        $this->assertEquals("PL", $binListNetResolver->check("2137"));
    }

}
