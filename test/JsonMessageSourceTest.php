<?php
declare(strict_types=1);
namespace yii\i18n;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};
use yii\console\{Application};

/**
 * Tests the features of the `yii\i18n\JsonMessageSource` class.
 */
class JsonMessageSourceTest extends TestCase {

  /**
   * @test JsonMessageSource::loadMessagesFromFile
   */
  public function testLoadMessagesFromFile(): void {
    $loadMessagesFromFile = function($messageFile) {
      return $this->loadMessagesFromFile($messageFile);
    };

    it('should properly load the JSON source and parse it as array', function() use ($loadMessagesFromFile) {
      $model = new JsonMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
      $messageFile = \Yii::getAlias("{$model->basePath}/fr/messages.json");
      expect($loadMessagesFromFile->call($model, $messageFile))->to->equal([
        'Hello World!' => 'Bonjour le monde !',
        'foo.bar.baz' => 'FooBarBaz'
      ]);
    });

    it('should enable proper translation of source strings', function() {
      $model = new JsonMessageSource(['basePath' => '@root/test/fixtures', 'enableNesting' => true]);
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
