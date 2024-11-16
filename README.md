
# Telegram Notifier

A simple PHP package for sending messages to Telegram using the Telegram Bot API.

## Installation

You can install the package via Composer:

```bash
composer require mohsen-najafizadeh/telegram-notifier
```

## Requirements

- **PHP version 7.2 and above**  
- **cURL extension enabled** for making requests to the Telegram API.

## Usage

Here is a basic example of how to use the package:

```php
use TelegramNotifier\Telegram;

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
- **$chatId** *(string)*: The chat ID to send the message to. After creating your bot and adding it to the desired chat, you can retrieve the chat ID by visiting the following link, replacing `<YOUR_BOT_TOKEN>` with your actual bot token: [Learn more](https://core.telegram.org/bots/api#getupdates)
    ```
    https://api.telegram.org/bot<YOUR_BOT_TOKEN>/getUpdates
    ```
- **$parseMode** *(string|null)*: Optional parameter to specify the parse mode. Valid values are `HTML`, `Markdown`, `MarkdownV2`.

## Error Handling and Common Issues

- Ensure that the bot token is correctly configured.
- Check that the chat ID is valid and that the bot has access to the chat.

## Contributing

If you would like to contribute to the development of this project, please submit your pull requests with sufficient explanations. Your feedback, bug reports, and suggestions are highly appreciated.

## License

This package is licensed under the MIT License.
