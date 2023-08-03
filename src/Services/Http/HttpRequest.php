<?php

declare(strict_types=1);

namespace App\Services\Http;

use App\Interfaces\ICache;

use function file_get_contents;
use function http_build_query;
use function json_decode;
use function json_encode;
use function stream_context_create;

class HttpRequest
{

    private string $baseUrl;
    private ICache $cache;

    //Implementamos a Interface do Cache, por que assim podemos utilizar qualquer Cache que implemente esse Contrato
    public function __construct(string $baseUrl, ICache $cache)
    {
        $this->baseUrl = $baseUrl;
        $this->cache = $cache;
    }

    public function get(string $endpoint): HttpResponse
    {
        if($this->cache->has($endpoint)) {
            return $this->cache->get($endpoint)['response'];
        }
        $response = $this->call('GET', $endpoint);
        //O Cache tem um TTL de 10 segundos
        $this->cache->set($endpoint, ['response' => $response], 10);

        return $response;
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

        //Aqui removo possíveis / que foram adicionadas pelo usuário
        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');

        $opts = [
            'http' => [
                'method'  => $method,
                'header'  => 'Content-type: application/json',
                'content' => $data ? json_encode($data) : null,
                'ignore_errors' => true //Ignora caso de erro 404
            ]
        ];

        $url .= ($parameters ? '?' . http_build_query($parameters) : '');
        
        $response = file_get_contents($url, false, stream_context_create($opts));

        //Aqui eu pego o código HTTP do Headers
        preg_match("#HTTP/[0-9\.]+\s+([0-9]+)#", $http_response_header[0], $out);
        $httpCode = intval($out[1]);


        
        return new HttpResponse(
            $httpCode,
            $http_response_header,
            json_decode($response, true)
        );
    }
}
