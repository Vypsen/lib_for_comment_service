<?php

namespace Vypsen\CommentsLib\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class CommentClient
{
    private string $baseUrl;
    private Client $client;

    public function __construct()
    {
        $this->baseUrl = 'localhost';
        $this->client = new Client();
    }

    public function getComments() : array
    {
        $url = $this->baseUrl . '/comments';

        try {
            $response = $this->client->get($url);
            return $this->validationResponse($response);

        } catch (RequestException $e) {
            throw new \Exception('Ошибка при получении комментариев: ' . $e->getMessage());
        }
    }

    public function setComment(string $name, string $text)
    {
        $url = $this->baseUrl . '/comment';
        $data = [
            'body' => [
                'name' => $name,
                'text' => $text,
            ]
        ];

        try {
            $response = $this->client->post($url, $data)->getBody();
            return $this->validationResponse($response);

        } catch (RequestException $e) {
            throw new \Exception('Ошибка при добавлении комментария: ' . $e->getMessage());
        }
    }

    public function updateComment(int $id, string $name, string $text)
    {
        $url = $this->baseUrl . '/comment/' . $id;
        $data = [
            'body' => [
                'name' => $name,
                'text' => $text,
            ]
        ];

        try {
            $response = $this->client->put($url, $data);
            return $this->validationResponse($response);

        } catch (RequestException $e) {
            throw new \Exception('Ошибка при обновлении комментария: ' . $e->getMessage());
        }
    }

    private function validationResponse($response): array
    {
        $body = json_decode($response->getBody(), true);

        if (isset($body['success']) && $body['success']) {
            return $body;
        } elseif (isset($body['errorCode']) && isset($body['errorMessage'])) {
            throw new \Exception('Ошибка (' . $body['errorCode'] . '): ' . $body['errorMessage']);
        } else {
            throw new \Exception('Неизвестная ошибка');
        }
    }
}