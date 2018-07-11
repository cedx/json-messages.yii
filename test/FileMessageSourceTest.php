<?php
declare(strict_types=1);
namespace yii\i18n;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};
use yii\console\{Application};

/**
 * Tests the features of the `yii\i18n\FileMessageSource` class.
 */
class FileMessageSourceTest extends TestCase {

  /**
   * @test FileMessageSource::flatten
   */
  public function testFlatten(): void {
    $flatten = function($array) {
      return $this->flatten($array);
    };

    it('should merge the keys of a multidimensional array', function() use ($flatten) {
      $model = new FileMessageSource;
      expect($flatten->call($model, []))->to->equal([]);
      expect($flatten->call($model, ['foo' => 'bar', 'baz' => 'qux']))->to->equal(['foo' => 'bar', 'baz' => 'qux']);
      expect($flatten->call($model, ['foo' => ['bar' => 'baz']]))->to->equal(['foo.bar' => 'baz']);

      $source = [
        'foo' => 'bar',
        'bar' => ['baz' => 'qux'],
        'baz' => ['qux' => [
          'foo' => 'bar',
          'bar' => 'baz'
        ]]
      ];

      expect($flatten->call($model, $source))->to->equal([
        'foo' => 'bar',
        'bar.baz' => 'qux',
        'baz.qux.foo' => 'bar',
        'baz.qux.bar' => 'baz'
      ]);
    });

    it('should allow different nesting separators', function() use ($flatten) {
      $source = [
        'foo' => 'bar',
        'bar' => ['baz' => 'qux'],
        'baz' => ['qux' => [
          'foo' => 'bar',
          'bar' => 'baz'
        ]]
      ];

      $model = new FileMessageSource(['nestingSeparator' => '/']);
      expect($flatten->call($model, $source))->to->equal([
        'foo' => 'bar',
        'bar/baz' => 'qux',
        'baz/qux/foo' => 'bar',
        'baz/qux/bar' => 'baz'
      ]);

      $model = new FileMessageSource(['nestingSeparator' => '->']);
      expect($flatten->call($model, $source))->to->equal([
        'foo' => 'bar',
        'bar->baz' => 'qux',
        'baz->qux->foo' => 'bar',
        'baz->qux->bar' => 'baz'
      ]);
    });
  }

  /**
   * @test FileMessageSource::getMessageFilePath
   */
  public function testGetMessageFilePath(): void {
    $getMessageFilePath = function($category, $language) {
      return $this->getMessageFilePath($category, $language);
    };

    it('should return the proper path to the message file', function() use ($getMessageFilePath) {
      $model = new FileMessageSource(['basePath' => '@root/test/fixtures']);
      $messageFile = str_replace('/', DIRECTORY_SEPARATOR, __DIR__.'/fixtures/fr/messages.php');
      expect($getMessageFilePath->call($model, 'messages', 'fr'))->to->equal($messageFile);
    });
  }

  /**
   * @test FileMessageSource::loadMessagesFromFile
   */
  public function testLoadMessagesFromFile(): void {
    $loadMessagesFromFile = function($messageFile) {
      return $this->loadMessagesFromFile($messageFile);
    };

    it('should properly load the JSON source and parse it as array', function() use ($loadMessagesFromFile) {
      $model = new FileMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
      $messageFile = \Yii::getAlias("{$model->basePath}/fr/messages.php");
      expect($loadMessagesFromFile->call($model, $messageFile))->to->equal([
        'Hello World!' => 'Bonjour le monde !',
        'foo.bar.baz' => 'FooBarBaz'
      ]);
    });

    it('should enable proper translation of source strings', function() {
      $model = new FileMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
      expect($model->translate('messages', 'Hello World!', 'fr'), 'Bonjour le monde !');
      expect($model->translate('messages', 'foo.bar.baz', 'fr'), 'FooBarBaz');
    });
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp(): void {
    new Application([
      'id' => 'yii2-i18n-messages',
      'basePath' => '@root/lib'
    ]);
  }
}
