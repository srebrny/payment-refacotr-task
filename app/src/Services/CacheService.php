<?php

namespace Application\Services;

use Application\Contracts\CacheableInterface;

class CacheService implements CacheableInterface
{
    public const string fileName = "app.cache";
    private array $cached = [];

    public function loadCache(): array
    {
        if (!$this->cached) {
            $data = file_get_contents(self::fileName);
            if (!$data) {
                return [];
            }

            $unserialized = unserialize($data, ["allowed_classes" => false]);
            if (false === $unserialized) {
                return [];
            }

            $this->cached = $unserialized;
        }
        return $this->cached;
    }

    public function saveCache(): bool
    {
        return file_put_contents(self::fileName, serialize($this->cached));
    }

    public function hasCache(string $key): bool
    {
        return array_key_exists($key, $this->cached);
    }

    public function getCache(string $key): ?string
    {
        return $this->cached[$key] ?? null;
    }

    public function setCache(string $key, string $value): self
    {
        $this->cached[$key] = $value;
        return $this;
    }
}
