<?php

namespace MohsenNajafizadeh\TelegramNotifier;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
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
            $body = json_decode($response->getBody()->getContents(), true);

            return [
                'headerCode' => $response->getStatusCode(),
                'status' => 'success',
                'message' => 'Message sent successfully!',
                'data' => $body['result']
            ];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);

            return [
                'headerCode' => $statusCode,
                'status' => 'error',
                'message' => $body['description'],
            ];
        } catch (TelegramException $e) {
            return [
                'headerCode' => 500,
                'status' => 'error',
                'message' => "An unexpected error occurred: " . $e->getMessage(),
            ];
        }
    }
}