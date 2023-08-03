<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Interfaces\ICache;
use DateInterval;
use DateTime;
class MemoryCache implements ICache
{

    private array $cache = [];

    public function get(string $key): array
    {
        if (!isset($this->cache[$key])) {
            return [];
        }

        if($this->cache[$key]['ttl'] < new DateTime('now')) {
            return [];
        }

        return $this->cache[$key]['data'];
    }

    public function set(string $key, array $value, int $ttl): void
    {
        $this->cache[$key] = [
            'ttl' => $this->setDateTTL($ttl),
            'data' => $value
        ];
    }

    public function delete(string $key): void
    {
        unset($this->cache[$key]);
    }

    public function flush(): void
    {
        $this->cache = [];
    }

    public function has(string $key): bool
    {
        if (!isset($this->cache[$key])) {
            return false;
        }

        if($this->cache[$key]['ttl'] < new DateTime('now')) {
            return false;
        }

        return true;
    }

    public function getAll(): array
    {
        return $this->cache;
    }
    
    private function setDateTTL(int $ttl): DateTime
    {
        $created_at = new DateTime('now');
        $dateInterval = new DateInterval('PT' . $ttl . 'S');
        return $created_at->add($dateInterval);
    }

}
