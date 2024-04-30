<?php

namespace Application\Contracts;

interface CacheableInterface
{
    public function loadCache(): array;

    public function saveCache(): bool;

    public function hasCache(string $key): bool;

    public function getCache(string $key): ?string;

    public function setCache(string $key, string $value);
}
