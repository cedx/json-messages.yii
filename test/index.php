<?php
/**
 * Entry point of the unit tests.
 * @module test.index
 */
use yii\console\Application;

// Set the environment.
define('YII_DEBUG', true);
define('YII_ENV', 'test');

// Load the dependencies.
$rootPath=dirname(__DIR__);
require_once $rootPath.'/vendor/autoload.php';
require_once $rootPath.'/vendor/yiisoft/yii2/Yii.php';
require_once $rootPath.'/lib/JsonMessageSource.php';

// Initialize the test application.
new Application([
  'id'=>'json-messages.yii',
  'basePath'=>$rootPath.'/lib',
  'vendorPath'=>$rootPath.'/vendor'
]);
