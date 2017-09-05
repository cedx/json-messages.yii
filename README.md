# JSON Messages for Yii
![Runtime](https://img.shields.io/badge/php-%3E%3D7.0-brightgreen.svg) ![Release](https://img.shields.io/packagist/v/cedx/yii2-json-messages.svg) ![License](https://img.shields.io/packagist/l/cedx/yii2-json-messages.svg) ![Downloads](https://img.shields.io/packagist/dt/cedx/yii2-json-messages.svg) ![Coverage](https://coveralls.io/repos/github/cedx/yii2-json-messages/badge.svg) ![Build](https://travis-ci.org/cedx/yii2-json-messages.svg)

[JSON](http://json.org) message source for [Yii](http://www.yiiframework.com), high-performance [PHP](https://secure.php.net) framework.

This package provides a single class, `yii\i18n\JsonMessageSource` which is a message source that stores translated messages in JSON files.
It extends from [`PhpMessageSource`](http://www.yiiframework.com/doc-2.0/yii-i18n-phpmessagesource.html) class, so its usage is basically the same.

Within a JSON file, an object literal of (source, translation) pairs is defined. For example:

```json
{
  "original message 1": "translated message 1",
  "original message 2": "translated message 2"
}
```

## Requirements
The latest [PHP](https://secure.php.net) and [Composer](https://getcomposer.org) versions.
If you plan to play with the sources, you will also need the latest [Phing](https://www.phing.info) version.

## Installing via [Composer](https://getcomposer.org)
From a command prompt, run:

```shell
$ composer global require fxp/composer-asset-plugin
$ composer require cedx/yii2-json-messages
```

## Usage
In your application configuration file, you can use the following message source:

```php
use yii\i18n\{JsonMessageSource};

return [
  'components' => [
    'i18n' => [
      'translations' => [
        '*' => JsonMessageSource::class
      ]
    ]
  ]
];
```

## See also
- [API reference](https://cedx.github.io/yii2-json-messages)
- [Code coverage](https://coveralls.io/github/cedx/yii2-json-messages)
- [Continuous integration](https://travis-ci.org/cedx/yii2-json-messages)

## License
[JSON Messages for Yii](https://github.com/cedx/yii2-json-messages) is distributed under the MIT License.
