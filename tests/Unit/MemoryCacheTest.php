<?php

namespace Tests\Unit;

use App\Services\Cache\MemoryCache;
use Tests\TestCase;

class MemoryCacheTest extends TestCase
{

    private $memoryCache;

    public function setUp(): void
    {
        parent::setUp();

        $this->memoryCache = new MemoryCache();
    }
    public function test_get_cache()
    {
        $this->memoryCache->set('foo', ['foo' => 'bar'], 4);



        $this->assertEquals(['foo' => 'bar'], $this->memoryCache->get('foo'));
    }

    public function test_ttl_cache_works()
    {
        $this->memoryCache->set('foo', ['foo' => 'bar'], 1);

        sleep(2);

        $this->assertEquals([], $this->memoryCache->get('foo'));
    }

    public function test_get_cache_not_found()
    {
        $this->assertEquals([], $this->memoryCache->get('foo'));
    }

    public function test_set_cache()
    {
        $this->memoryCache->set('foo', ['foo' => 'bar'], 10);

        $this->assertArrayHasKey('foo', $this->memoryCache->getAll());
    }

    public function test_set_multiple_cache()
    {
        $this->memoryCache->set('foo', ['foo' => 'bar'], 10);
        $this->memoryCache->set('asd', ['asd' => 'vac'], 10);
        $this->memoryCache->set('zxc', ['zxc' => 'vac'], 10);


        $this->assertArrayHasKey('foo', $this->memoryCache->getAll());
        $this->assertArrayHasKey('asd', $this->memoryCache->getAll());
        $this->assertArrayHasKey('zxc', $this->memoryCache->getAll());
    }

    public function test_delete_cache()
    {
        $this->memoryCache->set('foo', ['foo' => 'bar'], 10);

        $this->memoryCache->delete('foo');

        $this->assertArrayNotHasKey('foo', $this->memoryCache->getAll());
    }

    public function test_flush_cache()
    {
        $this->memoryCache->set('foo', ['foo' => 'bar'], 10);

        $this->memoryCache->flush();

        $this->assertEquals([], $this->memoryCache->getAll());
    }

    public function test_has_cache()
    {
        $this->memoryCache->set('foo', ['foo' => 'bar'], 10);

        $this->assertTrue($this->memoryCache->has('foo'));
        $this->assertFalse($this->memoryCache->has('bar'));
    }


}
