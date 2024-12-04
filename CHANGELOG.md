# Changelog

All notable changes to this project will be documented in this file.  
This project adheres to [Semantic Versioning](https://semver.org/).

---

## [v1.0.0] - Initial Release
### Added
- Initial implementation of the Telegram Notifier package.
- `sendMessage` method for sending messages to Telegram, supporting `message`, `botToken`, `chatId`, and `parse_mode`.
- Comprehensive unit tests for the `sendMessage` method, covering:
  - Successful message sending.
  - Handling of invalid bot tokens and incorrect chat IDs.
- Basic error handling for API errors and network issues using `TelegramException`.
- Support for customizable HTTP client configuration (`clientConfig`).
- Documentation, including installation and usage instructions.

#### Notes:
- The package was thoroughly tested in PHP and officially released as version 1.0.0, compatible with PHP 8.0 and above.
- This release consolidates all features and improvements into a stable initial version.

---
