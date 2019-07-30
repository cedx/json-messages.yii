<?php declare(strict_types=1);
namespace yii\i18n;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};

/** Tests the features of the `yii\i18n\YamlMessageSource` class. */
class YamlMessageSourceTest extends TestCase {

  /** @var \ReflectionClass The object used to change the visibility of inaccessible class members. */
  private static $reflection;

  /** @beforeClass This method is called before the first test of this test class is run. */
  static function setUpBeforeClass(): void {
    self::$reflection = new \ReflectionClass(YamlMessageSource::class);
  }

  /** @test YamlMessageSource->flatten() */
  function testFlatten(): void {
    $method = self::$reflection->getMethod('flatten');
    $method->setAccessible(true);

    it('should merge the keys of a multidimensional array', function() use ($method) {
      $model = new YamlMessageSource;
      expect($method->invoke($model, []))->to->equal([]);
      expect($method->invoke($model, ['foo' => 'bar', 'baz' => 'qux']))->to->equal(['foo' => 'bar', 'baz' => 'qux']);
      expect($method->invoke($model, ['foo' => ['bar' => 'baz']]))->to->equal(['foo.bar' => 'baz']);

      $source = [
        'foo' => 'bar',
        'bar' => ['baz' => 'qux'],
        'baz' => ['qux' => [
          'foo' => 'bar',
          'bar' => 'baz'
        ]]
      ];

      expect($method->invoke($model, $source))->to->equal([
        'foo' => 'bar',
        'bar.baz' => 'qux',
        'baz.qux.foo' => 'bar',
        'baz.qux.bar' => 'baz'
      ]);
    });

    it('should allow different nesting separators', function() use ($method) {
      $source = [
        'foo' => 'bar',
        'bar' => ['baz' => 'qux'],
        'baz' => ['qux' => [
          'foo' => 'bar',
          'bar' => 'baz'
        ]]
      ];

      $model = new YamlMessageSource(['nestingSeparator' => '/']);
      expect($method->invoke($model, $source))->to->equal([
        'foo' => 'bar',
        'bar/baz' => 'qux',
        'baz/qux/foo' => 'bar',
        'baz/qux/bar' => 'baz'
      ]);

      $model = new YamlMessageSource(['nestingSeparator' => '->']);
      expect($method->invoke($model, $source))->to->equal([
        'foo' => 'bar',
        'bar->baz' => 'qux',
        'baz->qux->foo' => 'bar',
        'baz->qux->bar' => 'baz'
      ]);
    });
  }

  /** @test YamlMessageSource->getMessageFilePath() */
  function testGetMessageFilePath(): void {
    $method = self::$reflection->getMethod('getMessageFilePath');
    $method->setAccessible(true);

    it('should return the proper path to the message file', function() use ($method) {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures']);
      $messageFile = str_replace('/', DIRECTORY_SEPARATOR, __DIR__.'/fixtures/fr/messages.yaml');
      expect($method->invoke($model, 'messages', 'fr'))->to->equal($messageFile);
    });

    it('should should support different file extensions', function() use ($method) {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'fileExtension' => 'yml']);
      $messageFile = str_replace('/', DIRECTORY_SEPARATOR, __DIR__.'/fixtures/fr/messages');
      expect($method->invoke($model, 'messages', 'fr'))->to->equal("$messageFile.yml");
    });
  }

  /** @test YamlMessageSource->loadMessagesFromFile() */
  function testLoadMessagesFromFile(): void {
    $method = self::$reflection->getMethod('loadMessagesFromFile');
    $method->setAccessible(true);

    it('should properly load the JSON source and parse it as array', function() use ($method) {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
      $messageFile = \Yii::getAlias("{$model->basePath}/fr/messages.yaml");
      expect($method->invoke($model, $messageFile))->to->equal([
        'Hello World!' => 'Bonjour le monde !',
        'foo.bar.baz' => 'FooBarBaz'
      ]);
    });

    it('should enable proper translation of source strings', function() {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
      expect($model->translate('messages', 'Hello World!', 'fr'))->to->equal('Bonjour le monde !');
      expect($model->translate('messages', 'foo.bar.baz', 'fr'))->to->equal('FooBarBaz');

      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true, 'nestingSeparator' => '/']);
      expect($model->translate('messages', 'foo/bar/baz', 'fr'))->to->equal('FooBarBaz');
    });
  }

  /** @test YamlMessageSource->parseMessages() */
  function testParseMessages(): void {
    $method = self::$reflection->getMethod('parseMessages');
    $method->setAccessible(true);

    it('should parse a YAML file as a hierarchical array', function() use ($method) {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
      $messages = $method->invoke($model, (string) file_get_contents(\Yii::getAlias("{$model->basePath}/fr/messages.yaml")));
      expect($messages)->to->equal([
        'Hello World!' => 'Bonjour le monde !',
        'foo' => ['bar' => ['baz' => 'FooBarBaz']]
      ]);
    });

    it('should parse an invalid YAML file as an empty array', function() use ($method) {
      $model = new YamlMessageSource(['basePath' => '@root/test/fixtures']);
      expect($method->invoke($model, ''))->to->be->empty;
    });
  }
}
