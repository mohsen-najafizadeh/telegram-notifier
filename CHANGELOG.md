# Changelog

All notable changes to this project will be documented in this file.  
This project adheres to [Semantic Versioning](https://semver.org/).

---

## [1.0.0] - Initial Release
### Added
- Initial implementation of the Telegram Notifier package.
- `sendMessage` method for sending messages to Telegram, supporting `message`, `botToken`, `chatId`, and `parse_mode`.
- Basic error handling for API errors and network issues using `TelegramException`.

#### Notes:
- The package was thoroughly tested in PHP and officially released as version 1.0.0, compatible with PHP 7.2 and above.

---

## [2.0.0] - Added Unit Tests and Updated PHP Version
### Added
- Comprehensive unit tests for the `sendMessage` method, covering:
    - Successful message sending.
    - Handling of invalid bot tokens and incorrect chat IDs.
- Improved error messages:
    - Detailed exception messages include HTTP status codes and Telegram API descriptions.
- Support for customizable HTTP client configuration (`clientConfig`).

### Changed
- PHP version requirement updated to PHP 8.0 due to limitations in PHPUnit and the testing process.

#### Notes:
- After completing and validating all tests, version 2.0.0 was released with improved stability and test coverage.

---

## [Unreleased]
### Planned
- Add documentation for version 2.0.0, including installation and usage instructions.
- Introduce a Dockerfile for containerized deployment of the package.
- Transition to maintenance mode:
    - Actively maintain the package for updates and compatibility.
    - Halt feature development after Docker support implementation.  