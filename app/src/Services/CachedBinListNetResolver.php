<?php

namespace Application\Services;

use Application\Contracts\BankIdentificationNumberResolverInterface;
use Application\Contracts\CacheableInterface;
use InvalidArgumentException;
use JsonException;

class CachedBinListNetResolver implements BankIdentificationNumberResolverInterface
{
    public function __construct(public CacheableInterface $cache)
    {
       $this->cache->loadCache();
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function check(string $binNumbers): string
    {
        if (!$this->cache->hasCache($binNumbers)) {
            $countryAlpha2 = $this->callBinService($binNumbers);
            $this->cache->setCache($binNumbers, $countryAlpha2);
        }

        return $this->cache->getCache($binNumbers);
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function callBinService(string $binNumber): string
    {
        $binResults = file_get_contents('https://lookup.binlist.net/' . $binNumber);
        if (!$binResults) {
            throw new InvalidArgumentException(message: "Bin data not found");
        }
        $r = json_decode($binResults, false, 512, JSON_THROW_ON_ERROR);
        return $r->country->alpha2;
    }
}
