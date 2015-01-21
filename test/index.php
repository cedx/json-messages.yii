<?php
/**
 * Entry point of the unit tests.
 * @module test.index
 */

// Load the dependencies.
$rootPath=dirname(__DIR__);
require_once $rootPath.'/vendor/yiisoft/yii/framework/yiit.php';

spl_autoload_unregister([ 'YiiBase','autoload' ]);
require_once $rootPath.'/vendor/phpunit/phpunit-story/PHPUnit/Extensions/Story/Autoload.php';
spl_autoload_register([ 'YiiBase','autoload' ]);

// Initialize the test application.
Yii::createConsoleApplication([
  'basePath'=>$rootPath.'/lib',
  'extensionPath'=>$rootPath.'/vendor'
]);
