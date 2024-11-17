<?php

namespace Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use MohsenNajafizadeh\TelegramNotifier\Exceptions\TelegramException;
use MohsenNajafizadeh\TelegramNotifier\Telegram;
use PHPUnit\Framework\TestCase;

class TelegramTest extends TestCase
{
    public function testSendMessageSuccess()
    {
        $responseBody = json_encode([
            'ok' => true,
            'result' => [
                'chat' => [
                    'id' => -1001234567890,
                    'title' => 'telegram channel name',
                    'type' => 'channel',
                ],
                'text' => 'test message',
                'message_id' => 17979,
                'date' => 1731823910,
            ],
        ]);

        $mockHandler = new MockHandler([
            new Response(200, [], $responseBody),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage(
            'test message',
            'fake-bot-token',
            '-1001234567890',
            null,
            ['client' => $mockClient]
        );

        $this->assertEquals(200, $result['header-code']);
        $this->assertEquals('success', $result['status']);
        $this->assertEquals('Message sent!', $result['message']);
    }

    public function testSendMessageChatIdError()
    {
        $this->expectException(TelegramException::class);
        $this->expectExceptionMessageMatches('/400 Bad Request/');
        $this->expectExceptionMessageMatches('/Bad Request: chat not found/');


        $responseBody = json_encode([
            'ok' => false,
            'error_code' => 400,
            'description' => 'Bad Request: chat not found',
        ]);

        $mockHandler = new MockHandler([
            new Response(400, [], $responseBody),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        Telegram::sendMessage(
            'Test message',
            'fake-bot-token',
            'invalid-chat-id',
            null,
            ['client' => $mockClient]
        );
    }

    public function testSendMessageInvalidBotToken()
    {
        $this->expectException(TelegramException::class);
        $this->expectExceptionMessageMatches('/401 Unauthorized/');
        $this->expectExceptionMessageMatches('/Unauthorized/');

        $responseBody = json_encode([
            'ok' => false,
            'error_code' => 401,
            'description' => 'Unauthorized',
        ]);

        $mockHandler = new MockHandler([
            new Response(401, [], $responseBody),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        Telegram::sendMessage(
            'Test message',
            'invalid-bot-token',
            'valid-chat-id',
            null,
            ['client' => $mockClient]
        );
    }

    public function testSendMessageInvalidParseMode()
    {
        $responseBody = json_encode([
            'ok' => true,
            'result' => [
                'chat' => [
                    'id' => 'valid-chat-id',
                    'title' => 'telegram channel',
                    'type' => 'channel',
                ],
                'text' => 'test message',
                'message_id' => 17980,
                'date' => 1731824088,
            ],
        ]);

        $mockHandler = new MockHandler([
            new Response(200, [], $responseBody),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage(
            'test message',
            'fake-bot-token',
            'valid-chat-id',
            'invalid_parse_mode',
            ['client' => $mockClient]
        );

        $this->assertEquals(200, $result['header-code']);
        $this->assertEquals('success', $result['status']);
        $this->assertEquals('Message sent!', $result['message']);
    }

    public function testSendMessageJsonDecodeError()
    {
        $this->expectException(TelegramException::class);
        $this->expectExceptionMessageMatches('/JSON decoding error/');

        $mockHandler = new MockHandler([
            new Response(200, [], 'invalid_json'),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        Telegram::sendMessage(
            'test message',
            'fake-bot-token',
            'valid-chat-id',
            null,
            ['client' => $mockClient]
        );
    }

    public function testSendMessageRequestException()
    {
        $this->expectException(TelegramException::class);
        $this->expectExceptionMessageMatches('/Failed to send message to Telegram/');

        $mockHandler = new MockHandler([
            new RequestException('Network error', new Request('POST', 'test')),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        Telegram::sendMessage(
            'test message',
            'fake-bot-token',
            'invalid-chat-id',
            null,
            ['client' => $mockClient]
        );
    }
}
