<?php

use App\HttpRequest;

require __DIR__ . '/../vendor/autoload.php';


$requestType = $_SERVER['REQUEST_METHOD'];

$request = new HttpRequest();


switch ($requestType) {
    case 'GET':
        $response = $request->call('GET', 'https://jsonplaceholder.typicode.com/posts/1');
        break;
    case 'POST':
        $response = $request->call('POST', 'https://jsonplaceholder.typicode.com/posts', ['title' => 'foo', 'body' => 'bar', 'userId' => 1]);
        break;
    case 'PUT':
        $response = $request->call('PUT', 'https://jsonplaceholder.typicode.com/posts/1', ['title' => 'foo', 'body' => 'bar', 'userId' => 1]);
        break;
    case 'DELETE':
        $response = $request->call('DELETE', 'https://jsonplaceholder.typicode.com/posts/1');
        break;
    default:
        $response = $request->call('GET', 'https://jsonplaceholder.typicode.com/posts/1');
        break;
}

$response->renderJson();
