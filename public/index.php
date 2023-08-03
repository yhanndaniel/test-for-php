<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\Cache\FileCache;
use App\Services\Cache\MemoryCache;
use App\Services\Http\HttpRequest;

$requestType = $_SERVER['REQUEST_METHOD'];

$baseUrl = 'https://jsonplaceholder.typicode.com/';

//A instancia dos 2 tipos de cache, para escolher qual utilizar é só injetar no HTTPRequest
$memoryCache = new MemoryCache();
$fileCache = new FileCache('production', realpath(__DIR__ . '/../storage/cache/'));
$request = new HttpRequest($baseUrl, $fileCache);


//De acordo com o tipo de request sera chamado o método correspondente
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

//Renderiza a resposta em JSON
$response->renderJson();
