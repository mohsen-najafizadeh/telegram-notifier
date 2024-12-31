# Changelog

All notable changes to this project will be documented in this file.  
This project adheres to [Semantic Versioning](https://semver.org/).

---
## [v1.1.0] - Updated error handling behavior in `sendMessage` method and improved tests

### Changed
- Revised error handling behavior for `sendMessage` to align with expected structured responses.
- Updated unit tests to reflect the new error handling changes, ensuring accurate simulation of Telegram API responses.
- Refactored `testSendMessageTelegramException` to properly validate scenarios involving server errors.

### Notes
- This release includes breaking changes in the behavior of error handling for invalid or missing parameters. Developers using the package should review their implementation to ensure compatibility.
---

## [v1.0.2] - Added Docker Support for Contributors and Updated PHP Version

### Added
- Dockerfile for creating a Docker image of the package.
- `docker-compose.yml` for easier container management.
- Documentation for using Docker with the package.

### Changed
- Updated PHP version requirement in `composer.json` from `^8.0` to `^8.2`.
- Replaced the existing `composer.lock` file with the one generated in the Docker container.

---

## [v1.0.1] - Add link to documentation in README
### Added
- Link to the [documentation](https://mohsen-najafizadeh.github.io/telegram-notifier/) in the `README.md`.

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
