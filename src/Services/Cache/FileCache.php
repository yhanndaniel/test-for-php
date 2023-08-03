<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Interfaces\ICache;
use DateInterval;
use DateTime;

class FileCache implements ICache
{

    private $scoopDir;
    private $dir;

    public function __construct(string $scoopDir = 'production', string $dir = './storage/cache/')
    {

        $this->scoopDir = rtrim($scoopDir, '/') . '/';
        $this->dir = rtrim($dir, '/') . '/';
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
        $key = $this->prepareKey($key);
        $cache = [
            'ttl' => $this->setDateTTL($ttl),
            'data' => $value
        ];

        if (!file_exists($this->dir . $this->scoopDir)) {
            mkdir($this->dir . $this->scoopDir, 0755, true);
        }

        $file = fopen($this->dir . $this->scoopDir.$key, 'w');
        fwrite($file, serialize($cache));
        fclose($file);
    }

    public function delete(string $key): void
    {
        $key = $this->prepareKey($key);
        $file = $this->dir . $this->scoopDir.$key;
        unlink($file);
    }

    public function flush(): void
    {
        $files = array_diff(scandir($this->dir . $this->scoopDir), ['.', '..']);

        foreach ($files as $file) {
            unlink($this->dir . $this->scoopDir.$file);
        }
    }

    public function has(string $key): bool
    {
        $key = $this->prepareKey($key);
        $fileContent = $this->getFileContent($key);

        if (!$fileContent) {
            return false;
        }

        $cache = unserialize($fileContent);

        if ($cache['ttl'] < new DateTime('now')) {
            return false;
        }

        return isset($cache);
    }

    public function getAll(): array
    {
        $files = array_diff(scandir($this->dir . $this->scoopDir), ['.', '..']);

        $cacheArray = [];
        foreach ($files as $file) {
            $fileContent = $this->getFileContent($file);

            $cacheArray[$file] = unserialize($fileContent);
        }

        return $cacheArray;
    }

    //Método para setar a data de expiração
    private function setDateTTL(int $ttl): DateTime
    {
        $created_at = new DateTime('now');
        $dateInterval = new DateInterval('PT' . $ttl . 'S');
        return $created_at->add($dateInterval);
    }

    //Método que verifica se o arquivo existe e já pega os dados
    private function getFileContent(string $key): string|false
    {
        $key = $this->prepareKey($key);
        $file = $this->dir . $this->scoopDir.$key;

        if (!file_exists($file)) {
            return false;
        }

        return file_get_contents($file);
    }

    //Método para preparar a chave pois arquivos não aceitam / então eu troquei por -
    private function prepareKey(string $key): string
    {
        return str_replace('/', '-', $key);
    }
}
