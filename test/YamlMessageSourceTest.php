<?php
declare(strict_types=1);
namespace yii\i18n;

use PHPUnit\Framework\{TestCase};

/**
 * Tests the features of the `yii\i18n\YamlMessageSource` class.
 */
class YamlMessageSourceTest extends TestCase {

  /**
   * @var \ReflectionClass The object used to change the visibility of inaccessible class members.
   */
  private static $reflection;

  /**
   * This method is called before the first test of this test class is run.
   * @beforeClass
   */
  static function setUpBeforeClass(): void {
    static::$reflection = new \ReflectionClass(YamlMessageSource::class);
  }

  /**
   * Tests the `YamlMessageSource::flatten()` method.
   * @test
   */
  function testFlatten(): void {
    $method = static::$reflection->getMethod('flatten');
    $method->setAccessible(true);

    // It should merge the keys of a multidimensional array.
    $model = new YamlMessageSource;
    assertThat($method->invoke($model, []), equalTo([]));
    assertThat($method->invoke($model, ['foo' => 'bar', 'baz' => 'qux']), equalTo(['foo' => 'bar', 'baz' => 'qux']));
    assertThat($method->invoke($model, ['foo' => ['bar' => 'baz']]), equalTo(['foo.bar' => 'baz']));

    $source = [
      'foo' => 'bar',
      'bar' => ['baz' => 'qux'],
      'baz' => ['qux' => [
        'foo' => 'bar',
        'bar' => 'baz'
      ]]
    ];

    assertThat($method->invoke($model, $source), equalTo([
      'foo' => 'bar',
      'bar.baz' => 'qux',
      'baz.qux.foo' => 'bar',
      'baz.qux.bar' => 'baz'
    ]));

    // It should allow different nesting separators.
    $source = [
      'foo' => 'bar',
      'bar' => ['baz' => 'qux'],
      'baz' => ['qux' => [
        'foo' => 'bar',
        'bar' => 'baz'
      ]]
    ];

    $model = new YamlMessageSource(['nestingSeparator' => '/']);
    assertThat($method->invoke($model, $source), equalTo([
      'foo' => 'bar',
      'bar/baz' => 'qux',
      'baz/qux/foo' => 'bar',
      'baz/qux/bar' => 'baz'
    ]));

    $model = new YamlMessageSource(['nestingSeparator' => '->']);
    assertThat($method->invoke($model, $source), equalTo([
      'foo' => 'bar',
      'bar->baz' => 'qux',
      'baz->qux->foo' => 'bar',
      'baz->qux->bar' => 'baz'
    ]));
  }

  /**
   * Tests the `YamlMessageSource::getMessageFilePath()` method.
   * @test
   */
  function testGetMessageFilePath(): void {
    $method = static::$reflection->getMethod('getMessageFilePath');
    $method->setAccessible(true);

    // It should return the proper path to the message file.
    $model = new YamlMessageSource(['basePath' => '@root/test/fixtures']);
    $messageFile = str_replace('/', DIRECTORY_SEPARATOR, __DIR__.'/fixtures/fr/messages.yaml');
    assertThat($method->invoke($model, 'messages', 'fr'), equalTo($messageFile));

    // It should should support different file extensions.
    $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'fileExtension' => 'yml']);
    $messageFile = str_replace('/', DIRECTORY_SEPARATOR, __DIR__.'/fixtures/fr/messages');
    assertThat($method->invoke($model, 'messages', 'fr'), equalTo("$messageFile.yml"));
  }

  /**
   * Tests the `YamlMessageSource::loadMessagesFromFile()` method.
   * @test
   */
  function testLoadMessagesFromFile(): void {
    $method = static::$reflection->getMethod('loadMessagesFromFile');
    $method->setAccessible(true);

    // It should properly load the JSON source and parse it as array.
    $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
    $messageFile = \Yii::getAlias("{$model->basePath}/fr/messages.yaml");
    assertThat($method->invoke($model, $messageFile), equalTo([
      'Hello World!' => 'Bonjour le monde !',
      'foo.bar.baz' => 'FooBarBaz'
    ]));

    // It should enable proper translation of source strings.
    $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
    assertThat($model->translate('messages', 'Hello World!', 'fr'), equalTo('Bonjour le monde !'));
    assertThat($model->translate('messages', 'foo.bar.baz', 'fr'), equalTo('FooBarBaz'));

    $model->nestingSeparator = '/';
    assertThat($model->translate('messages', 'foo/bar/baz', 'fr'), equalTo('FooBarBaz'));
  }

  /**
   * Tests the `YamlMessageSource::parseMessages()` method.
   * @test
   */
  function testParseMessages(): void {
    $method = static::$reflection->getMethod('parseMessages');
    $method->setAccessible(true);

    // It should parse a YAML file as a hierarchical array.
    $model = new YamlMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
    $messages = $method->invoke($model, (string) file_get_contents(\Yii::getAlias("{$model->basePath}/fr/messages.yaml")));
    assertThat($messages, equalTo([
      'Hello World!' => 'Bonjour le monde !',
      'foo' => ['bar' => ['baz' => 'FooBarBaz']]
    ]));

    // It should parse an invalid YAML file as an empty array.
    $model = new YamlMessageSource(['basePath' => '@root/test/fixtures']);
    assertThat($method->invoke($model, ''), isEmpty());
  }
}
