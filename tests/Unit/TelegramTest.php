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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TypeError;

class TelegramTest extends TestCase
{
    /**
     * @throws TelegramException
     */
    public function testSendMessageSuccess()
    {
        $responseBody = json_encode([
            'ok' => true,
            'result' => [
                'chat' => [
                    'id' => -1001234567890,
                    'title' => 'Telegram channel name',
                    'type' => 'channel',
                ],
                'text' => 'message',
                'message_id' => 12345,
                'date' => 1731823910,
            ],
        ]);

        $mockHandler = new MockHandler([
            new Response(200, [], $responseBody),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage(
            'message',
            'bot-token',
            'chat-id',
            null,
            ['client' => $mockClient]
        );

        $this->assertSame(200, $result['header-code']);
        $this->assertSame('success', $result['status']);
        $this->assertSame('Message sent!', $result['message']);
        $this->assertSame(12345, $result['data']['message_id']);
    }

    /**
     * @throws TelegramException
     */
    #[DataProvider('sendMessageRequiredArgumentsProvider')]
    public function testSendMessageRequiredArguments($message, $botToken, $chatId)
    {
        $this->expectException(TypeError::class);

        Telegram::sendMessage($message, $botToken, $chatId);
    }

    public static function sendMessageRequiredArgumentsProvider(): array
    {
        return [
            [null, 'bot-token', 'chat-id'],
            ['message', null, 'chat-id'],
            ['message', 'bot-token', null],
        ];
    }

    /**
     * @throws TelegramException
     */
    #[DataProvider('sendMessageInvalidArgumentsProvider')]
    public function testSendMessageInvalidArguments($errorCode)
    {
        $description = 'Error';
        $this->expectException(TelegramException::class);
        $this->expectExceptionCode($errorCode);
        $this->expectExceptionMessageMatches('/' . $description . '/');

        $responseBody = json_encode([
            'ok' => false,
            'error_code' => $errorCode,
            'description' => $description,
        ]);

        $mockHandler = new MockHandler([
            new Response($errorCode, [], $responseBody),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        Telegram::sendMessage(
            'message',
            'bot-token',
            'chat-id',
            null,
            ['client' => $mockClient]
        );
    }

    public static function sendMessageInvalidArgumentsProvider(): array
    {
        return [
            [400],
            [401],
            [403],
            [404],
            [500],
            [502],
            [503],
            [504],
        ];
    }

    public function testSendMessageJsonDecodeError()
    {
        $this->expectException(TelegramException::class);
        $this->expectExceptionMessageMatches('/JSON decoding error/');

        $mockHandler = new MockHandler([
            new Response(200, [], 'Invalid json'),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        Telegram::sendMessage(
            'message',
            'bot-token',
            'chat-id',
            null,
            ['client' => $mockClient]
        );
    }

    public function testSendMessageRequestException()
    {
        $this->expectException(TelegramException::class);
        $this->expectExceptionMessageMatches('/Failed to send message to Telegram/');

        $mockHandler = new MockHandler([
            new RequestException('Network error', new Request('POST', '')),
        ]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        Telegram::sendMessage(
            'message',
            'bot-token',
            'chat-id',
            null,
            ['client' => $mockClient]
        );
    }
}
