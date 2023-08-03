<?php

declare(strict_types=1);

namespace App\Services\Http;

class HttpResponse
{
    private int $httpCode;
    private array $httpResponseHeader;
    private array $httpResponseBody;

    public function __construct(
        int $httpCode,
        array $httpResponseHeader,
        array $httpResponseBody
    ) {
        $this->httpCode = $httpCode;
        $this->httpResponseHeader = $httpResponseHeader;
        $this->httpResponseBody = $httpResponseBody;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getHttpResponseHeader(): array
    {
        return $this->httpResponseHeader;
    }

    public function getHttpResponseBody(): array
    {
        return $this->httpResponseBody;
    }

    public function renderJson(): void
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
     
        http_response_code($this->httpCode);

        $response = array(
            'Headers' => $this->httpResponseHeader,
            'Body' => $this->httpResponseBody
        );
        
        echo json_encode($response);
    }
}
