<?php declare(strict_types=1);
use yii\i18n\{JsonMessageSource};

/** Translates a message. */
function main(): void {
  // Using flat mapping.
  Yii::$app->i18n->translations['app*'] = new JsonMessageSource;
  echo Yii::t('app', 'FooBarBaz');

  // Using nested objects.
  Yii::$app->i18n->translations['app*'] = new JsonMessageSource(['enableNesting' => true]);
  echo Yii::t('app', 'foo.bar.baz');
}
