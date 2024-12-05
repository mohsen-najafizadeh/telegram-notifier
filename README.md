
# Telegram Notifier

A simple PHP package for sending messages to Telegram using the Telegram Bot API.

## Features

- Send messages to Telegram channels and users.
- Easy integration with your PHP projects.
- Uses Guzzle HTTP Client for robust API communication.

## Installation

You can install the package via Composer:

```bash
  composer require mohsen-najafizadeh/telegram-notifier
```

## Requirements

- PHP 8.0 and above.
- Guzzle HTTP Client (Version 7.0 and above).

## Quick Start

Here’s how you can send a simple message using the package:

```php
use MohsenNajafizadeh\TelegramNotifier\Telegram;

$response = Telegram::sendMessage($message, $botToken, $chatId);
```
For detailed documentation and examples, refer to the [Documentation](DOCUMENTATION.md) /  [Documentation that created by PHPDocumentor](https://mohsen-najafizadeh.github.io/telegram-notifier/).

## Contribution
If you want to contribute to the project, please read the [Contributing Guidelines](CONTRIBUTING.md).

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
