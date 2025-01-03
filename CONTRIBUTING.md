
# Contributing to TelegramNotifier

Thank you for considering contributing to the TelegramNotifier package! We welcome contributions of all kinds, including bug reports, feature suggestions, and pull requests.

---

## How to Contribute

### 1. Reporting Issues
- Before reporting an issue, please check [the issues](https://github.com/mohsen-najafizadeh/telegram-notifier/issues) to ensure it hasn’t been reported already.
- If you find an issue, please include:
    - A clear and descriptive title.
    - Steps to reproduce the problem.
    - Expected vs. actual behavior.
    - Any relevant logs or error messages.

### 2. Suggesting Features
- Open a new issue with the title `Feature Request: [Feature Name]`.
- Describe the feature in detail, including why it’s useful and how it improves the package.

### 3. Submitting Pull Requests
- Fork the repository and create a new branch for your changes, based on the `develop` branch:
    ```bash
    git checkout -b feature/your-feature-name develop
    ```
- Ensure your code adheres to the project's coding standards.
- Add or update tests for any new functionality.
- Run all tests to ensure they pass.
- Update [`README.md`](README.md) or other documentation if applicable.
- Submit your pull request to the `develop` branch with a clear and concise description of your changes.

---

## Development Workflow

To ensure consistency across all contributors, the development environment is Dockerized.

### 1. Clone the Repository
   ```bash
      git clone https://github.com/mohsen-najafizadeh/telegram-notifier.git
      cd telegram-notifier
   ```

### 2. Build and Run the Docker Container
   ```bash
      docker-compose up --build
   ```

### 3. Access the Development Container
   ```bash
      docker exec -it telegram-notifier-dev /bin/bash
   ```

### 4. Stop the Container
   ```bash
      docker-compose down
   ```

### Notes on Development
- All development work should be done inside the Docker container to maintain consistency across environments.
- The `develop` branch is used for ongoing work. The `main` branch is reserved for stable releases.
- Follow [Semantic Versioning](https://semver.org/) when introducing changes that impact the public API.

---

Thank you for contributing to TelegramNotifier!
