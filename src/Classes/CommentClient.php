<?php

namespace Vypsen\CommentsLib\Classes;

use GuzzleHttp\Client;

class CommentClient
{
    private string $baseUrl;
    private $client;

    public function __construct()
    {
        $this->baseUrl = 'http://example.com';
        $this->client = new Client();
    }

    public function getComments()
    {
        $res = $this->client->request('GET', 'https://api.publicapis.org/random');
        echo $res;
    }

    public function setComment()
    {
        return file_get_contents(self::$url ."/comments");
    }
}