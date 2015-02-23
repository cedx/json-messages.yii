<?php
/**
 * Entry point of the unit tests.
 * @module test.index
 */

// Load the dependencies.
$rootPath=dirname(__DIR__);
require_once $rootPath.'/vendor/autoload.php';
require_once $rootPath.'/vendor/yiisoft/yii2/Yii.php';

/* TODO
spl_autoload_unregister([ 'YiiBase','autoload' ]);
require_once $rootPath.'/vendor/phpunit/phpunit-story/PHPUnit/Extensions/Story/Autoload.php';
require_once('PHPUnit/Autoload.php');
spl_autoload_register([ 'YiiBase','autoload' ]);
*/

// Initialize the test application.
Yii::setPathOfAlias('belin', $rootPath.'/lib');
Yii::createConsoleApplication([
  'basePath'=>$rootPath.'/lib',
  'vendorPath'=>$rootPath.'/vendor'
]);

<?php
/**
 * Entry point of the server application.
 * @module www.index
 */
use app\Application;

// Set the environment.
$remoteAddress=(isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? 'HTTP_X_FORWARDED_FOR' : 'REMOTE_ADDR');
$devEnvironment=in_array(getenv($remoteAddress), [ '127.0.0.1', '::1' ]);

if(!gc_enabled()) gc_enable();
define('APP_ROOT', getenv('APP_ROOT') ?: dirname(__DIR__));
define('YII_DEBUG', getenv('YII_DEBUG') ?: ($devEnvironment || (PHP_SAPI=='cli' ? in_array('--debug', $argv) : isset($_GET['debug']))));
define('YII_ENV', getenv('YII_ENV') ?: ($devEnvironment ? 'dev' : 'prod'));

// Load the dependencies.
require_once APP_ROOT.'/vendor/autoload.php';
require_once APP_ROOT.'/vendor/yiisoft/yii2/Yii.php';
require_once APP_ROOT.'/lib/server/Application.php';

// Start the application.
$config=Application::loadConfig(APP_ROOT.'/etc');
(new Application($config))->run();
