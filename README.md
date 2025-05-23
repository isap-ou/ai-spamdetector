# AI SpamDetector
AI SpamDetector is a lightweight, framework-agnostic PHP library designed to intelligently detect spam in form submissions using OpenAI’s GPT models. It analyzes message content, user metadata, and email patterns to help you prevent unwanted or bot-generated form entries with minimal setup.

[![AI SpamDetector](https://static.isap.me/ai-spamdetector.jpg)](https://github.com/isap-ou/ai-spamdetector)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/isapp/ai-spamdetector.svg?style=flat-square)](https://packagist.org/packages/isapp/ai-spamdetector)
[![Total Downloads](https://img.shields.io/packagist/dt/isapp/ai-spamdetector.svg?style=flat-square)](https://packagist.org/packages/isapp/ai-spamdetector)
## Installation

You can install the package via composer:

```bash
composer require isapp/ai-spamdetector
```

## Basic Usage

```php
use Isapp\AiSpamdetector\Client;use Isapp\AiSpamdetector\FormData;use Isapp\AiSpamdetector\SpamDetector;

$client = new Client(apiKey: getenv('OPENAI_API_KEY'), organization: getenv('OPENAI_ORGANIZATION'),model: 'gpt-4');
$detector = new SpamDetector(client: $client);

$form = new FormData(
    name: 'James Bond',
    email: 'freeprizes@cheapbiz.com',
    message: 'Click here for FREE cash!!!',
    userAgent: $_SERVER['HTTP_USER_AGENT'] ?? null,
);

$isNotSpam = $detector->analyze($form); // returns true if message is not spam
```

### Class: FormData

The `FormData` class acts as a structured container for submitted form data. It supports optional fields and omits
`null` values when serialized to JSON.

#### Constructor

```php
new FormData(
    ?string $name = null,
    ?string $firstName = null,
    ?string $lastName = null,
    ?string $phoneNumber = null,
    ?string $email,
    string $message,
    ?string $userAgent = null
)
```

#### Properties

| Property      | Type    | Description                              |
|---------------|---------|------------------------------------------|
| `name`        | ?string | Full name (if not split into first/last) |
| `firstName`   | ?string | First name                               |
| `lastName`    | ?string | Last name                                |
| `phoneNumber` | ?string | Phone number                             |
| `email`       | ?string | Email address                            |
| `message`     | string  | The message content                      |
| `userAgent`   | ?string | Browser user-agent (optional)            |

#### Methods

- `toJson(): string`  
  Serializes the form to JSON, skipping all `null` fields.

### Class: Client

The `Client` class is a lightweight wrapper around the official OpenAI PHP client. It simplifies authentication and
allows you to specify a model.

#### Constructor

```php
new Client(
    string $apiKey,
    ?string $organization = null,
    string $model = 'gpt-4'
)
```

#### Methods

- `make(): \OpenAI\Client`  
  Returns the underlying `openai-php/client` instance.

- `getModel(): string`  
  Returns the currently configured OpenAI model (e.g., `gpt-4`).

These methods allow you to configure the client before making requests:

- `setApiKey(string $apiKey): static` - Sets a new OpenAI API key.

- `setModel(string $model): static`  - Sets the model to be used (e.g. `gpt-4`, `gpt-3.5-turbo`).

- `setOrganization(?string $organization): static`  - Sets the OpenAI organization ID (optional).

- `setProject(?string $project): static` - Sets the OpenAI project ID (optional).

- `setBaseUri(string $baseUri): static` - Sets a custom API base URI (default: `api.openai.com/v1`).

All setters return `$this`, allowing fluent configuration.

## Contributing

Contributions are welcome! If you have suggestions for improvements, new features, or find any issues, feel free to
submit a pull request or open an [issue](https://github.com/isap-ou/laravel-agile-crm/issues) in this repository.

Thank you for helping make this package better for the community!

## License

This project is open-sourced software licensed under the [MIT License](https://opensource.org/licenses/MIT).

You are free to use, modify, and distribute it in your projects, as long as you comply with the terms of the license.

---

Maintained by [ISAPP](https://isapp.be) and [ISAP OÜ](https://isap.me).  
Check out our software development services at [isap.me](https://isap.me).