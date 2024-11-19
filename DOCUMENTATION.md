
# Telegram Notifier Documentation

## 1. Introduction

**Telegram Notifier** is a simple and powerful package for sending messages to Telegram. Built using GuzzleHttp Client, it allows you to easily send text messages through the Telegram API.

---

## 2. Installation

To install the package, use Composer:

```bash
composer require mohsen-najafizadeh/telegram-notifier
```

---

## 3. Quick Start

### Sending a Simple Message
To send a message to Telegram:
```php
use MohsenNajafizadeh\TelegramNotifier\Telegram;

$botToken = 'your-bot-token';
$chatId = 'your-chat-id';
$message = 'Hello, Telegram!';

$response = Telegram::sendMessage($message, $botToken, $chatId);
print_r($response);
```

---

## 4. Configuration

### Guzzle Parameters
You can customize Guzzle’s behavior by providing a configuration array:
```php
$clientConfig = [
    'timeout' => 10, // Timeout duration
    'base_uri' => 'https://api.telegram.org', // Telegram API base URI
];

$response = Telegram::sendMessage($message, $botToken, $chatId, null, $clientConfig);
```

### Available Parameters
- **timeout**: Timeout duration in seconds.
- **base_uri**: Base URI for API (default: `https://api.telegram.org`).

---

## 5. API Methods

### sendMessage
Sends a message to Telegram.

#### Parameters
| Parameter       | Type      | Required | Description                           |
|-----------------|-----------|----------|---------------------------------------|
| `$message`      | `string`  | Yes      | The message text to send.             |
| `$botToken`     | `string`  | Yes      | Telegram bot token.                   |
| `$chatId`       | `string`  | Yes      | Chat ID or username to send message.  |
| `$parseMode`    | `string`  | No       | Text format (`Markdown` or `HTML`).   |
| `$clientConfig` | `array`   | No       | Additional Guzzle configurations.     |

#### Response
An array containing the following details:
- `header-code`: HTTP status code.
- `status`: Request status (`success` or `error`).
- `message`: Description of the send result.
- `data`: API response data (on success).

#### Success Example
```php
$response = Telegram::sendMessage('Hello!', $botToken, $chatId);
print_r($response);

/*
Array
(
    [header-code] => 200
    [status] => success
    [message] => Message sent!
    [data] => Array
        (
            [message_id] => 123
            [chat] => ...
        )
)
*/
```

#### Error Example
If the message fails to send:
```php
try {
    Telegram::sendMessage('Hello!', $invalidBotToken, $chatId);
} catch (\MohsenNajafizadeh\TelegramNotifier\Exceptions\TelegramException $e) {
    echo $e->getMessage();
    // Output: Telegram API error: Unauthorized
}
```

---

## 6. Error Handling

If an error occurs, the package throws a `TelegramException`. You can handle the exception message like this:
```php
use MohsenNajafizadeh\TelegramNotifier\Exceptions\TelegramException;

try {
    Telegram::sendMessage($message, $botToken, $chatId);
} catch (TelegramException $e) {
    echo 'Error: ' . $e->getMessage();
    echo 'Code: ' . $e->getCode();
}
```

---

## 7. Tests

This package includes PHPUnit tests. Run the tests using:
```bash
./vendor/bin/phpunit tests/Unit/TelegramTest.php
```

---

## 8. Changelog

For details about version changes, see the `CHANGELOG.md` file.

---

## 9. Contributing

We welcome contributions! Please read the `CONTRIBUTING.md` file before submitting changes.

---

## 10. FAQ

### 1. Does this package support sending photos or files?
Currently, the package is designed for sending text messages only, but it is extendable.

### 2. How can I report issues?
Please report issues in the GitHub Issues section.

---

## 11. References
- [Telegram Bot API Documentation](https://core.telegram.org/bots/api)
- [GuzzleHttp Documentation](https://docs.guzzlephp.org/)

