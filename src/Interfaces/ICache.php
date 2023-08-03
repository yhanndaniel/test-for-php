<?php

declare(strict_types=1);

namespace App\Interfaces;

interface ICache
{
    public function get(string $key): array;
    public function set(string $key, array $value, int $ttl): void;
    public function delete(string $key): void;
    public function flush(): void;
    public function has(string $key): bool;
    public function getAll(): array;
}
