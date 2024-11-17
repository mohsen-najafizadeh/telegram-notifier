
# Telegram Notifier

A simple PHP package for sending messages to Telegram using the Telegram Bot API.

## Installation

You can install the package via Composer:

```bash
composer require mohsen-najafizadeh/telegram-notifier
```

## Requirements

- **PHP version 8.0 and above**
- **cURL extension enabled** for making requests to the Telegram API.
- **Guzzle HTTP Client** (Version 7.0 and above) - Used for making HTTP requests to the Telegram API.
- **JSON extension** - Ensures handling of JSON encoding and decoding.

## Usage

Here is a basic example of how to use the package:

```php
use MohsenNajafizadeh\TelegramNotifier\Telegram;

$message = "Hello, this is a test message.";
$botToken = 'YOUR_BOT_TOKEN';
$chatId = 'CHAT_ID';

$response = Telegram::sendMessage($message, $botToken, $chatId);

if ($response->getStatusCode() === 200) {
    echo "Message sent successfully!";
} else {
    echo "Failed to send message.";
}
```

## Parameters

- **$message** *(string)*: The text message you want to send.
- **$botToken** *(string)*: Your Telegram bot token. To create a Telegram bot token, please visit [BotFather](https://t.me/BotFather).
- **$chatId** *(string)*: The chat ID of the user or channel you want to send the message to.
- **$parseMode** *(string|null)*: Optional parameter to specify the parse mode. Valid values are `HTML`, `Markdown`, `MarkdownV2`. For more options and detailed explanations, refer to the [Telegram Bot API Documentation](https://core.telegram.org/bots/api#sendmessage).

## Advanced Usage

You can customize additional parameters for Telegram messages, such as sending photos, setting parse modes, etc. For more advanced configurations and parameter options, see the [Telegram Bot API Documentation](https://core.telegram.org/bots/api). Here is an example:

```php
$options = [
    'parse_mode' => 'Markdown',
    'disable_notification' => true
];

$response = Telegram::sendMessage($message, $botToken, $chatId, $options);
```

## Common Issues and Troubleshooting

- **Invalid Bot Token Error**: Ensure your bot token is correctly generated from [BotFather](https://t.me/BotFather).
- **Message Not Delivered**: Verify that your bot has permission to send messages to the specified chat ID.
- **Help**: After creating your bot and adding it to the desired chat, you can retrieve the chat ID by visiting the following link, replacing `<YOUR_BOT_TOKEN>` with your actual bot token: [Learn more](https://core.telegram.org/bots/api#getupdates)
    ```
    https://api.telegram.org/bot<YOUR_BOT_TOKEN>/getUpdates
    ```

## Development

If you are interested in contributing or running tests, here are the development dependencies and tools used:

- **PHPUnit** - Used for unit testing. To run tests, use:

    ```bash
    composer test
    ```

- **vlucas/phpdotenv** - Used for handling environment variables during development.

## Autoloading and Namespace

This package uses `PSR-4` autoloading, with the namespace `MohsenNajafizadeh\TelegramNotifier\`. All classes are located in the `src` directory.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
