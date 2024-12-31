<?php

namespace MohsenNajafizadeh\TelegramNotifier\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use MohsenNajafizadeh\TelegramNotifier\Exceptions\TelegramException;
use MohsenNajafizadeh\TelegramNotifier\Telegram;
use PHPUnit\Framework\TestCase;

class TelegramTest extends TestCase
{
    /**
     * @throws TelegramException
     */
    public function testSendMessageSuccess()
    {
        $mockHandler = new MockHandler([new Response(200, [], json_encode(['ok' => true, 'result' => []]))]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage('Test message', 'bot-token', 'chat-id', null, ['client' => $mockClient]);

        $this->assertSame(200, $result['headerCode']);
        $this->assertSame('success', $result['status']);
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageMissingBotToken()
    {
        $result = Telegram::sendMessage('Test message', '', 'chat-id');

        $this->assertSame(404, $result['headerCode']);
        $this->assertSame('error', $result['status']);
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageMissingMessage()
    {
        $mockHandler = new MockHandler([new Response(400, [], json_encode(['ok' => false, 'description' => 'Bad Request: message text is empty']))]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage('Test message', 'invalid-bot-token', 'invalid chat-id', null, ['client' =>
            $mockClient]);

        $this->assertSame(400, $result['headerCode']);
        $this->assertSame('error', $result['status']);
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageMissingChatId()
    {
        $mockHandler = new MockHandler([new Response(400, [], json_encode(['ok' => false, 'description' => 'Invalid chat_id']))]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage('Test message', 'invalid-bot-token', 'invalid chat-id', null, ['client' =>
            $mockClient]);

        $this->assertSame(400, $result['headerCode']);
        $this->assertSame('error', $result['status']);
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageInvalidBotToken()
    {
        $mockHandler = new MockHandler([new Response(401, [], json_encode(['ok' => false, 'description' => 'Invalid token']))]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage('Test message', 'invalid-bot-token', 'chat-id', null, ['client' => $mockClient]);

        $this->assertSame(401, $result['headerCode']);
        $this->assertSame('error', $result['status']);
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageInvalidChatId()
    {
        $mockHandler = new MockHandler([new Response(400, [], json_encode(['ok' => false, 'description' => 'Invalid chat id']))]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage('Test message', 'bot-token', 'invalid-chat-id', null, ['client' => $mockClient]);

        $this->assertSame(400, $result['headerCode']);
        $this->assertSame('error', $result['status']);
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageWithoutParseMode()
    {
        $mockHandler = new MockHandler([new Response(200, [], json_encode(['ok' => true, 'result' => []]))]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage('Test message', 'bot-token', 'chat-id', null, ['client' => $mockClient]);

        $this->assertSame(200, $result['headerCode']);
        $this->assertSame('success', $result['status']);
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageParseModeHTML()
    {
        $mockHandler = new MockHandler([new Response(200, [], json_encode(['ok' => true, 'result' => []]))]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage('Test message', 'bot-token', 'chat-id', 'HTML', ['client' => $mockClient]);

        $this->assertSame(200, $result['headerCode']);
        $this->assertSame('success', $result['status']);
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageParseModeMarkdown()
    {
        $mockHandler = new MockHandler([new Response(200, [], json_encode(['ok' => true, 'result' => []]))]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage('Test message', 'bot-token', 'chat-id', 'Markdown', ['client' => $mockClient]);

        $this->assertSame(200, $result['headerCode']);
        $this->assertSame('success', $result['status']);
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageParseModeMarkdownV2()
    {
        $mockHandler = new MockHandler([new Response(200, [], json_encode(['ok' => true, 'result' => []]))]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage('Test message', 'bot-token', 'chat-id', 'MarkdownV2', ['client' => $mockClient]);

        $this->assertSame(200, $result['headerCode']);
        $this->assertSame('success', $result['status']);
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageInvalidParseMode()
    {
        $mockHandler = new MockHandler([new Response(400, [], json_encode(['ok' => false, 'description' => 'Invalid parse mode']))]);
        $handlerStack = HandlerStack::create($mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $result = Telegram::sendMessage('Test message', 'bot-token', 'chat-id', 'InvalidParseMode', ['client' => $mockClient]);

        $this->assertSame(400, $result['headerCode']);
        $this->assertSame('error', $result['status']);
    }

}