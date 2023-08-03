<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Interfaces\ICache;
use DateInterval;
use DateTime;

class FileCache implements ICache
{

    private $scoopDir;
    private const DIR = './storage/cache/';

    public function __construct(string $scoopDir = 'production')
    {

        $this->scoopDir = rtrim($scoopDir, '/') . '/';
    }
    public function get(string $key): array
    {
        $fileContent = $this->getFileContent($key);

        if (!$fileContent) {
            return [];
        }

        $cache = unserialize($fileContent);

        if ($cache['ttl'] < new DateTime('now')) {
            return [];
        }

        return $cache['data'];
    }

    public function set(string $key, array $value, int $ttl): void
    {
        $cache = [
            'ttl' => $this->setDateTTL($ttl),
            'data' => $value
        ];

        if (!file_exists(self::DIR . $this->scoopDir)) {
            mkdir(self::DIR . $this->scoopDir, 0755, true);
        }

        $file = fopen(self::DIR . $this->scoopDir.$key, 'w');
        fwrite($file, serialize($cache));
        fclose($file);
    }

    public function delete(string $key): void
    {
        $file = self::DIR . $this->scoopDir.$key;
        unlink($file);
    }

    public function flush(): void
    {
        $files = array_diff(scandir(self::DIR . $this->scoopDir), ['.', '..']);

        foreach ($files as $file) {
            unlink(self::DIR . $this->scoopDir.$file);
        }
    }

    public function has(string $key): bool
    {
        $fileContent = $this->getFileContent($key);

        if (!$fileContent) {
            return false;
        }

        $cache = unserialize($fileContent);

        return isset($cache);
    }

    public function getAll(): array
    {
        $files = array_diff(scandir(self::DIR . $this->scoopDir), ['.', '..']);

        $cacheArray = [];
        foreach ($files as $file) {
            $fileContent = $this->getFileContent($file);

            $cacheArray[$file] = unserialize($fileContent);
        }

        return $cacheArray;
    }

    private function setDateTTL(int $ttl): DateTime
    {
        $created_at = new DateTime('now');
        $dateInterval = new DateInterval('PT' . $ttl . 'S');
        return $created_at->add($dateInterval);
    }

    private function getFileContent(string $key): string|false
    {
        $file = self::DIR . $this->scoopDir.$key;

        if (!file_exists($file)) {
            return false;
        }

        return file_get_contents($file);
    }
}
