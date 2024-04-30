<?php

namespace Unit\Services;

use Application\Contracts\CacheableInterface;
use Application\Services\CacheService;
use Codeception\Test\Unit;

class CacheServiceTest extends Unit
{
    public function testBasicOperations(): void
    {
        $cache = new CacheService();

        $key = "45717360";

        $this->assertInstanceOf(CacheableInterface::class, $cache->setCache($key, "DK"));
        $this->assertTrue($cache->hasCache($key));

        $this->assertEquals("DK", $cache->getCache("45717360"));
        $this->assertEquals("DK", $cache->getCache('45717360'));
        $this->assertEquals("DK", $cache->getCache(45717360));

        $this->assertNull($cache->getCache(2137));
    }

    public function testSaveAndLoadCache(): void
    {
        $cache = new CacheService();

        // example values
        $cache->setCache("45717360", "DK");
        $cache->setCache("516793", "UK");
        $cache->setCache("41417360", "EX");

        $this->assertTrue($cache->hasCache("45717360"));
        $this->assertTrue($cache->hasCache("516793"));
        $this->assertTrue($cache->hasCache("41417360"));

        $this->assertTrue($cache->saveCache());
        $this->assertFileExists("app.cache");

        unset($cache);

        $cache2 = new CacheService();
        $this->assertIsArray($cache2->loadCache());
        $this->assertEquals("DK", $cache2->getCache("45717360") );
        $this->assertEquals("UK", $cache2->getCache("516793") );
        $this->assertEquals("EX", $cache2->getCache("41417360") );
    }
}
