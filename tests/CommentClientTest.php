<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Vypsen\CommentsLib\Classes\CommentClient;

require_once __DIR__ . '/../src/Classes/CommentClient.php';

class CommentClientTest extends TestCase
{
    private CommentClient $commentClient;

    protected function setUp(): void
    {
        $this->commentClient = new CommentClient();
    }

    public function testCodeSuccessGetComments()
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                '{"data": [{"id": 1, "name": "User", "text": "Comment"}, {"id": 2, "name": "User2", "text": "Comment2"}]}'),
        ]);

        $this->createMockHandler($mockHandler);

        $comments = $this->commentClient->getComments();
        $dataBody = json_decode($comments->getBody()->getContents(), true);

        $this->assertEquals(200, $comments->getStatusCode());
        $this->assertIsArray($dataBody);
        $this->assertEquals('1', $dataBody['data'][0]['id']);
        $this->assertEquals('2', $dataBody['data'][1]['id']);
        $this->assertEquals('User', $dataBody['data'][0]['name']);
        $this->assertEquals('User2', $dataBody['data'][1]['name']);
    }

    public function testNotFoundDataComments()
    {
        $mockHandler = new MockHandler([
            new Response(
                404,
                [],
                '{"data": []}'),
        ]);

        $this->createMockHandler($mockHandler);

        $comments = $this->commentClient->getComments();
        $dataBody = json_decode($comments->getBody()->getContents(), true);

        $this->assertEquals(404, $comments->getStatusCode());
        $this->assertEmpty($dataBody['data']);
    }

    public function testSuccessSetComment()
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                '{"success": true }'
            ),
        ]);

        $this->createMockHandler($mockHandler);

        $name = 'User';
        $text = 'Comment';
        $result = json_decode($this->commentClient->setComment($name, $text)->getBody()->getContents(), true);

        $this->assertTrue($result['success']);
    }

    public function testFailSetComment()
    {
        $mockHandler = new MockHandler([
            new Response(
                500,
                [],
                '{"success": false }'
            ),
        ]);

        $this->createMockHandler($mockHandler);

        $name = 'User';
        $text = 'Comment';

        $result = json_decode($this->commentClient->setComment($name, $text)->getBody()->getContents(), true);

        $this->assertFalse($result['success']);
    }

    public function testNotFoundUpdateComment()
    {
        $mockHandler = new MockHandler([
            new Response(
                404,
                [],
                '{"success": false }'
            ),
        ]);

        $this->createMockHandler($mockHandler);

        $id = 1;
        $name = 'User';
        $text = 'Comment';

        $data = $this->commentClient->updateComment($id, $name, $text);
        $result = json_decode($data->getBody()->getContents(), true);

        $this->assertFalse($result['success']);
        $this->assertEquals(404, $data->getStatusCode());
    }

    public function testSuccessUpdateComment()
    {
        $mockHandler = new MockHandler([
            new Response(
                200,
                [],
                '{"success": true }'
            ),
        ]);

        $this->createMockHandler($mockHandler);

        $id = 1;
        $name = 'User';
        $text = 'Comment';

        $data = $this->commentClient->updateComment($id, $name, $text);
        $result = json_decode($data->getBody()->getContents(), true);

        $this->assertTrue($result['success']);
        $this->assertEquals(200, $data->getStatusCode());
    }

    public function testFailUpdateComment()
    {
        $mockHandler = new MockHandler([
            new Response(
                500,
                [],
                '{"success": false }'
            ),
        ]);

        $this->createMockHandler($mockHandler);

        $id = 1;
        $name = 'User';
        $text = 'Comment';

        $data = $this->commentClient->updateComment($id, $name, $text);
        $result = json_decode($data->getBody()->getContents(), true);

        $this->assertFalse($result['success']);
        $this->assertEquals(500, $data->getStatusCode());
    }

    public function testGetBaseUrl()
    {
        $this->assertIsString($this->commentClient->getUrl());
    }

    private function createMockHandler(MockHandler $mockHandler)
    {
        $handlerStack = HandlerStack::create($mockHandler);

        $this->commentClient = new CommentClient();
        $this->commentClient->setHandlerStack($handlerStack);
    }

}
