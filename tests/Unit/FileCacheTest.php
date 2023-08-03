<?php

namespace Tests\Unit;

use App\Services\Cache\FileCache;
use Tests\TestCase;

class FileCacheTest extends TestCase
{
    private $fileCache;

    public function setUp(): void
    {
        parent::setUp();

        $this->fileCache = new FileCache('testing');
    }

    public function test_get_cache()
    {
        $this->fileCache->set('foo', ['foo' => 'bar'], 4);

        $this->assertEquals(['foo' => 'bar'], $this->fileCache->get('foo'));
    }

    public function test_ttl_cache_works()
    {
        $this->fileCache->set('foo', ['foo' => 'bar'], 1);

        sleep(2);

        $this->assertEquals([], $this->fileCache->get('foo'));
    }

    public function test_get_cache_not_found()
    {
        $this->assertEquals([], $this->fileCache->get('foo'));
    }

    public function test_set_cache()
    {
        $this->fileCache->set('foo', ['foo' => 'bar'], 10);

        $this->assertArrayHasKey('foo', $this->fileCache->getAll());
    }

    public function test_set_multiple_cache()
    {
        $this->fileCache->set('foo', ['foo' => 'bar'], 10);
        $this->fileCache->set('asd', ['asd' => 'vac'], 10);
        $this->fileCache->set('zxc', ['zxc' => 'vac'], 10);


        $this->assertArrayHasKey('foo', $this->fileCache->getAll());
        $this->assertArrayHasKey('asd', $this->fileCache->getAll());
        $this->assertArrayHasKey('zxc', $this->fileCache->getAll());
    }

    public function test_delete_cache()
    {
        $this->fileCache->set('foo', ['foo' => 'bar'], 10);

        $this->fileCache->delete('foo');

        $this->assertArrayNotHasKey('foo', $this->fileCache->getAll());
    }

    public function test_flush_cache()
    {
        $this->fileCache->set('foo', ['foo' => 'bar'], 10);

        $this->fileCache->flush();

        $this->assertEquals([], $this->fileCache->getAll());
    }

    public function test_has_cache()
    {
        $this->fileCache->set('foo', ['foo' => 'bar'], 10);

        $this->assertTrue($this->fileCache->has('foo'));
        $this->assertFalse($this->fileCache->has('bar'));
    }
}