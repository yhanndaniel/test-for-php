<?php

use App\HttpRequest;

require __DIR__ . '/../vendor/autoload.php';


$requestType = $_SERVER['REQUEST_METHOD'];

$baseUrl = 'https://jsonplaceholder.typicode.com/';

$request = new HttpRequest($baseUrl);


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
