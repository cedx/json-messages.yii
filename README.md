# JSON Messages for Yii
![PHP](https://img.shields.io/badge/php-%3E%3D7.1-brightgreen.svg) ![Yii Framework](https://img.shields.io/badge/yii-%3E%3D2.0-brightgreen.svg) ![Release](https://img.shields.io/packagist/v/cedx/yii2-json-messages.svg) ![License](https://img.shields.io/packagist/l/cedx/yii2-json-messages.svg) ![Downloads](https://img.shields.io/packagist/dt/cedx/yii2-json-messages.svg) ![Coverage](https://coveralls.io/repos/github/cedx/yii2-json-messages/badge.svg) ![Build](https://travis-ci.org/cedx/yii2-json-messages.svg)

[JSON](http://json.org) message source for [Yii](http://www.yiiframework.com), high-performance [PHP](https://secure.php.net) framework.

## Resources
- [Documentation](https://cedx.github.io/yii2-json-messages)
- [API reference](https://cedx.github.io/yii2-json-messages/api)
- [Packagist package](https://packagist.org/packages/cedx/yii2-json-messages)
- [GitHub repository](https://github.com/cedx/yii2-json-messages)

## Requirements
The latest [PHP](https://secure.php.net) and [Composer](https://getcomposer.org) versions.
If you plan to play with the sources, you will also need the latest [Phing](https://www.phing.info) version.

## Installing via [Composer](https://getcomposer.org)
From a command prompt, run:

```shell
composer global require fxp/composer-asset-plugin
composer require cedx/yii2-json-messages
```

## Usage
This package provides a single class, `yii\i18n\JsonMessageSource` which is a message source that stores translated messages in JSON files.
It extends from [`PhpMessageSource`](http://www.yiiframework.com/doc-2.0/yii-i18n-phpmessagesource.html) class, so its usage is basically the same.

In your application configuration file, use the following message source:

```php
use yii\i18n\{JsonMessageSource};

return [
  'components' => [
    'i18n' => [
      'translations' => [
        'app' => JsonMessageSource::class
      ]
    ]
  ]
];
```

Within a JSON file, an object literal of (source, translation) pairs provides the message catalog. For example:

```json
{
  "original message 1": "translated message 1",
  "original message 2": "translated message 2"
}
```

See the [Yii guide](http://www.yiiframework.com/doc-2.0/guide-tutorial-i18n.html#message-translation) for more information about internationalization and message translation.

### Nested JSON objects
It is a common practice to use keys instead of original messages, alongside the enablement of the [`yii\i18n\JsonMessageSource::$forceTranslation`](http://www.yiiframework.com/doc-2.0/yii-i18n-messagesource.html#$forceTranslation-detail) property. For example:

```json
{
  "foo.bar": "translated message for key 'foo.bar'",
  "bar.qux": "translated message for key 'bar.qux'"
}
```

The `yii\i18n\JsonMessageSource` class understands nested JSON objects.
This means that you can have JSON files that look like this:

```json
{
  "foo": "translated message for key path 'foo'",
  "bar": {
    "qux": "translated message for key path 'bar.qux'"
  },
  "baz": {
    "qux": {
      "quux": "translated message for key path 'baz.qux.quux'"
    }
  }
}
```

And use dot notation to access a translation:

```php
echo \Yii::t('app', 'baz.qux.quux');
// Prints: translated message for key path 'baz.qux.quux'
```

To optin for this feature, you must set the `$enableNesting` property:

```php
// In the application configuration file.
return [
  'components' => [
    'i18n' => [
      'translations' => [
        'app' => [
          'class' => JsonMessageSource::class,
          'enableNesting' => true,
          'forceTranslation' => true
        ]
      ]
    ]
  ]
];
```

If you don't want to use the dot notation, you can customize the character(s) used by setting the `$nestingSeparator` property. For example, to use the slash character (e.g. `/`) as property delimiter:

```php
return [
  'components' => [
    'i18n' => [
      'translations' => [
        'app' => [
          'class' => JsonMessageSource::class,
          'nestingSeparator' => '/'
        ]
      ]
    ]
  ]
];
```

You can then access a translation by using the customized notation:

```php
// Using the slash character.
echo \Yii::t('app', 'foo/bar/baz');

// Using the "->" string.
echo \Yii::t('app', 'foo->bar->baz');
```

## License
[JSON Messages for Yii](https://cedx.github.io/yii2-json-messages) is distributed under the MIT License.
