# JSON-Messages.yii
[![Release](http://img.shields.io/packagist/v/cedx/yii2-json-messages.svg?style=flat)](https://packagist.org/packages/cedx/yii2-json-messages) [![License](http://img.shields.io/packagist/l/cedx/yii2-json-messages.svg?style=flat)](https://github.com/cedx/json-messages.yii/blob/master/LICENSE.txt) [![Downloads](http://img.shields.io/packagist/dt/cedx/yii2-json-messages.svg?style=flat)](https://packagist.org/packages/cedx/yii2-json-messages) [![Build](http://img.shields.io/travis/cedx/json-messages.yii.svg?style=flat)](https://travis-ci.org/cedx/json-messages.yii)

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

## Documentation
- [API Reference](http://dev.belin.io/json-messages.yii/api)

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
		'*' => 'yii\\i18n\\JsonMessageSource'
	  ]
    ]
  ]
];
```

## License
[JSON-Messages.yii](https://packagist.org/packages/cedx/yii2-json-messages) is distributed under the MIT License.
