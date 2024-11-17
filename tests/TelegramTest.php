<?php

use MohsenNajafizadeh\TelegramNotifier\Telegram;
use MohsenNajafizadeh\TelegramNotifier\Exceptions\TelegramException;
use PHPUnit\Framework\TestCase;

class TelegramTest extends TestCase
{
    private $botToken;
    private $chatId;

    protected function setUp(): void
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->botToken = $_ENV['BOT_TOKEN'];
        $this->chatId = $_ENV['CHAT_ID'];
    }

    /**
     * @throws TelegramException
     */
    public function testSendMessageSuccessfully()
    {
        $result = Telegram::sendMessage('Test message', $this->botToken, $this->chatId);

        $this->assertIsInt($result['header-code']);
        $this->assertSame(200, $result['header-code']);
        $this->assertIsString($result['status']);
        $this->assertSame('success', $result['status']);
        $this->assertIsString($result['message']);
        $this->assertSame('Message sent!', $result['message']);
        $this->assertArrayHasKey('message_id', $result['data']);
    }
}
