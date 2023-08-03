<?php

declare(strict_types=1);

namespace App;

use function file_get_contents;
use function http_build_query;
use function json_decode;
use function json_encode;
use function stream_context_create;

class HttpRequest
{

    private string $baseUrl;

    public function __construct(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function get(string $endpoint): HttpResponse
    {
        return $this->call('GET', $endpoint);
    }

    public function post(string $endpoint, array $parameters = null, array $data = null): HttpResponse
    {
        return $this->call('POST', $endpoint, $parameters, $data);
    }

    public function put(string $endpoint, array $parameters = null, array $data = null): HttpResponse
    {
        return $this->call('PUT', $endpoint, $parameters, $data);
    }

    public function delete(string $endpoint): HttpResponse
    {
        return $this->call('DELETE', $endpoint);
    }
    private function call(string $method, string $endpoint, array $parameters = null, array $data = null): HttpResponse
    {

        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');

        $opts = [
            'http' => [
                'method'  => $method,
                'header'  => 'Content-type: application/json',
                'content' => $data ? json_encode($data) : null,
                'ignore_errors' => true
            ]
        ];

        $url .= ($parameters ? '?' . http_build_query($parameters) : '');
        
        $response = file_get_contents($url, false, stream_context_create($opts));

        preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $http_response_header[0], $out);
        $httpCode = intval($out[1]);


        
        return new HttpResponse(
            $httpCode,
            $http_response_header,
            json_decode($response, true)
        );
    }
}
