# JSON-Messages.yii
![Release](http://img.shields.io/packagist/v/cedx/yii2-json-messages.svg) ![License](http://img.shields.io/packagist/l/cedx/yii2-json-messages.svg) ![Downloads](http://img.shields.io/packagist/dt/cedx/yii2-json-messages.svg) ![Build](http://img.shields.io/travis/cedx/json-messages.yii.svg)

[JSON](http://json.org) message source for [Yii](http://www.yiiframework.com), high-performance [PHP](https://php.net) framework.

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
The latest [PHP](http://php.net) and [Composer](https://getcomposer.org) versions.
If you plan to play with the sources, you will also need the latest versions of the following products:

- [Doxygen](http://www.doxygen.org)
- [Phing](https://www.phing.info)
- [PHP Mess Detector](http://phpmd.org)
- [PHPUnit](https://phpunit.de)

## Documentation
- [API Reference](http://api.belin.io/json-messages.yii)
- [Code Analysis](http://src.belin.io/dashboard/index/json-messages.yii)

## Installing via [Composer](https://getcomposer.org)
From a command prompt, run:

```shell
$ composer require cedx/yii2-json-messages
```

Now in your application configuration file, you can use the following message source:

```php
return [
  'components' => [
    'i18n' => [
      'translations' => [
        '*' => 'yii\i18n\JsonMessageSource'
      ]
    ]
  ]
];
```

## License
[JSON-Messages.yii](https://packagist.org/packages/cedx/yii2-json-messages) is distributed under the Apache License, version 2.0.
