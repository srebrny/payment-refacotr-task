<?php

namespace Unit\Providers;

use Application\Providers\InputFileProvider;
use Codeception\Test\Unit;
use Tests\Support\UnitTester;

class InputFileProviderTest extends Unit
{
    protected UnitTester $tester;

    public function testInputFileProvider(): void
    {
        $provider = new InputFileProvider();
        $this->assertNull($provider->getData());
        $this->assertIsNotArray($provider->getData());
    }

    /**
     * @throws \Exception
     */
    public function testLoadingFile(): void
    {
        $this->tester->expectThrowable(\Exception::class, function() {
            $provider = new InputFileProvider();
            $provider->load();
        });

        $provider = new InputFileProvider();
        $provider
            ->setFileName("input.txt")
            ->load();

        $this->assertNotNull($provider->getData());
        $this->assertCount(5, $provider->getData());
    }
}
