<?php
/**
 * Entry point of the unit tests.
 * @module test.index
 */
 
// Module dependencies.
use \yii\console\Application;

// Set the environment.
define('YII_DEBUG', true);
define('YII_ENV', 'test');

// Load the dependencies.
$rootPath=dirname(__DIR__);
require_once $rootPath.'/vendor/autoload.php';
require_once $rootPath.'/vendor/yiisoft/yii2/Yii.php';

// Initialize the application.
Yii::setAlias('@root', $rootPath);
Yii::setAlias('@yii/i18n', '@root/lib');

new Application([
  'id'=>'json-messages.yii',
  'basePath'=>'@root/lib',
  'vendorPath'=>'@root/vendor'
]);
