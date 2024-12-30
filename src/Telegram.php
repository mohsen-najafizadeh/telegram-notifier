<?php

namespace MohsenNajafizadeh\TelegramNotifier;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use MohsenNajafizadeh\TelegramNotifier\Exceptions\TelegramException;

class Telegram
{
    /**
     * @param string $message
     * @param string $botToken
     * @param string $chatId
     * @param string|null $parseMode
     * @param array $clientConfig
     * @return array
     * @throws TelegramException
     */
    public static function sendMessage(string $message, string $botToken, string $chatId, ?string $parseMode = null, array $clientConfig = []): array
    {
        $defaultConfig = [
            'base_uri' => 'https://api.telegram.org',
            'timeout' => 5.0
        ];
        $client = $clientConfig['client'] ?? new Client(array_merge($defaultConfig, $clientConfig));

        $formParams = [
            'text' => $message,
            'chat_id' => $chatId,
        ];

        if ($parseMode) {
            $formParams['parse_mode'] = $parseMode;
        }

        try {
            /** @noinspection PhpUnnecessaryCurlyVarSyntaxInspection */
            $response = $client->post("/bot{$botToken}/sendMessage", [
                'form_params' => $formParams,
            ]);
        } catch (TelegramException $e) {
            return [
                'header-code' => $e->getCode(),
                'status' => 'error',
                'message' => "Failed to send message to Telegram: " . $e->getMessage(),
            ];
        }

        $body = json_decode($response->getBody(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new TelegramException("JSON decoding error: " . json_last_error_msg());
        }

        if (isset($body['ok']) && $body['ok'] === true) {
            return [
                'header-code' => 200,
                'status' => 'success',
                'message' => 'Message sent!',
                'data' => $body['result'] ?? [],
            ];
        }

        return [
            'header-code' => $body['error_code'] ?? 422,
            'status' => 'error',
            'message' => $body['description'] ?? 'Unknown error',
        ];
    }
}