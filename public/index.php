<?php

use App\Services\Cache\FileCache;
use App\Services\Cache\MemoryCache;
use App\Services\Http\HttpRequest;

require_once __DIR__ . '/../vendor/autoload.php';


$requestType = $_SERVER['REQUEST_METHOD'];

$baseUrl = 'https://jsonplaceholder.typicode.com/';

$memoryCache = new MemoryCache();
$fileCache = new FileCache('production', realpath(__DIR__ . '/../storage/cache/'));

$request = new HttpRequest($baseUrl, $fileCache);


switch ($requestType) {
    case 'GET':
        $response = $request->get('posts/1');
        break;
    case 'POST':
        $response = $request->post('posts', [], ['title' => 'foo', 'body' => 'bar', 'userId' => 1]);
        break;
    case 'PUT':
        $response = $request->put('posts/1', [], ['title' => 'foo', 'body' => 'bar', 'userId' => 1]);
        break;
    case 'DELETE':
        $response = $request->delete('posts/1');
        break;
    default:
        $response = $request->get('posts/');
        break;
}

$response->renderJson();
