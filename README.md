# JSON Messages for Yii
![Release](https://img.shields.io/packagist/v/cedx/yii2-json-messages.svg) ![License](https://img.shields.io/packagist/l/cedx/yii2-json-messages.svg) ![Downloads](https://img.shields.io/packagist/dt/cedx/yii2-json-messages.svg) ![Code quality](https://img.shields.io/codacy/grade/e631d88b086e4f5d99c89273b779512f.svg) ![Build](https://img.shields.io/travis/cedx/yii2-json-messages.svg)

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
If you plan to play with the sources, you will also need the [Phing](https://www.phing.info) latest version.

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

## See Also
- [Code Quality](https://www.codacy.com/app/cedx/yii2-json-messages)
- [Continuous Integration](https://travis-ci.org/cedx/yii2-json-messages)

## License
[JSON Messages for Yii](https://github.com/cedx/yii2-json-messages) is distributed under the Apache License, version 2.0.
