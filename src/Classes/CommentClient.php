<?php

namespace Vypsen\CommentsLib\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Vypsen\CommentsLib\Traits\HttpRequestTrait;

class CommentClient
{
    use HttpRequestTrait;

    private string $baseUrl;
    private Client $client;

    public function __construct()
    {
        $this->baseUrl = 'http://example';
        $this->client = $this->createDefaultClient();
    }

    public function setHandlerStack(HandlerStack $handlerStack)
    {
        $this->client = new Client(['handler' => $handlerStack]);
    }

    private function createDefaultClient(): Client
    {
        return new Client();
    }

    public function getComments()
    {
        $url = $this->getUrl() . '/comments';

        return $this->performGetRequest($this->client, $url);
    }

    public function setComment(string $name, string $text)
    {
        $url = $this->getUrl() . '/comment';
        $data = [
            'form_params' => [
                'name' => $name,
                'text' => $text,
            ]
        ];

        return $this->performPostRequest($this->client, $url, $data);
    }

    public function updateComment(int $id, string $name, string $text)
    {
        $url = $this->getUrl() . '/comment/' . $id;
        $data = [
            'form_params' => [
                'name' => $name,
                'text' => $text,
            ]
        ];

        return $this->performPutRequest($this->client, $url, $data);
    }

    public function getUrl(): string
    {
        return $this->baseUrl;
    }
}