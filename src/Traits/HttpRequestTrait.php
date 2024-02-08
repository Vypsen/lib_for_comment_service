<?php

namespace Vypsen\CommentsLib\Traits;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

trait HttpRequestTrait
{
    private ResponseInterface $response;

    private function performGetRequest(ClientInterface $httpClient, string $url)
    {
        $this->response = $httpClient->get($url, ['http_errors' => false]);
        return $this->response;
    }

    private function performPostRequest(ClientInterface $httpClient, string $url, array $data)
    {

        $this->response = $httpClient->post($url, $data + ['http_errors' => false]);
        return $this->response;
    }

    private function performPutRequest(ClientInterface $httpClient, string $url, array $data)
    {
        $this->response = $httpClient->put($url, $data + ['http_errors' => false]);
        return $this->response;
    }
}