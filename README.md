# Simple Locize

Simple Locize is a PHP library for handling translations via the Locize API. Locize is a translation management system that allows you to easily manage your application's translations.

## Installation

You can install Simple Locize via Composer. Run the following command in your terminal:

```bash
composer require maxoplata/simple-locize
```

## Usage

To use Simple Locize, you first need to create an instance of the `SimpleLocize` class:

```php
use Maxoplata\SimpleLocize;

$projectId = 'your-project-id';
$environment = 'your-environment';
$privateKey = 'your-private-key'; // optional

$locize = new SimpleLocize($projectId, $environment, $privateKey);
```

### Fetching translations

To fetch translations for a specific namespace and language, you can use the `getAllTranslationsFromNamespace` method:

```php
$namespace = 'your-namespace';
$language = 'en';

$translations = $locize->getAllTranslationsFromNamespace($namespace, $language);
```

This will return an object containing all translations for the specified namespace and language.

### Translating a key

To translate a specific key for a namespace and language, you can use the `translate` method:

```php
$namespace = 'your-namespace';
$language = 'en';
$key = 'your.key';

$translation = $locize->translate($namespace, $language, $key);
```

This will return the translation for the specified key, or the key itself if no translation is found.

## License

Simple Locize is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
