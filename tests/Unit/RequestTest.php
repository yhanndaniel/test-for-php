<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\HttpRequest;
use App\HttpResponse;
use Tests\TestCase;

class RequestTest extends TestCase
{

    private HttpRequest $request;
    public function setUp(): void
    {
        parent::setUp();

        $this->request = new HttpRequest('https://jsonplaceholder.typicode.com/');
    }
    public function test_get(): void
    {
        $response = $this->request->get('posts/1');

        $this->assertInstanceOf(HttpResponse::class, $response);
        $this->assertEquals(200, $response->getHttpCode());
    }

    public function test_get_not_found(): void
    {
        $response = $this->request->get('postss/1');

        $this->assertInstanceOf(HttpResponse::class, $response);
        $this->assertEquals(404, $response->getHttpCode());
    }

    public function test_post(): void
    {
        $response = $this->request->post('posts', [], ['title' => 'foo', 'body' => 'bar', 'userId' => 1]);

        $this->assertInstanceOf(HttpResponse::class, $response);
        $this->assertEquals(201, $response->getHttpCode());
        $this->assertIsArray($response->getHttpResponseBody());
        $this->assertEquals('foo', $response->getHttpResponseBody()['title']);
        $this->assertEquals('bar', $response->getHttpResponseBody()['body']);
        $this->assertEquals(1, $response->getHttpResponseBody()['userId']);
    }

    public function test_put(): void
    {
        $response = $this->request->put('posts/1', [], ['title' => 'foo', 'body' => 'bar', 'userId' => 1]);

        $this->assertInstanceOf(HttpResponse::class, $response);
        $this->assertEquals(200, $response->getHttpCode());
        $this->assertIsArray($response->getHttpResponseBody());
        $this->assertEquals('foo', $response->getHttpResponseBody()['title']);
        $this->assertEquals('bar', $response->getHttpResponseBody()['body']);
        $this->assertEquals(1, $response->getHttpResponseBody()['userId']);
    }

    public function test_delete(): void
    {
        $response = $this->request->delete('posts/1');

        $this->assertInstanceOf(HttpResponse::class, $response);
        $this->assertEquals(200, $response->getHttpCode());
    }
}
