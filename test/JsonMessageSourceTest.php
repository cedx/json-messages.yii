<?php
declare(strict_types=1);
namespace yii\i18n;

use function PHPUnit\Expect\{expect, it};
use PHPUnit\Framework\{TestCase};

/**
 * Tests the features of the `yii\i18n\JsonMessageSource` class.
 */
class JsonMessageSourceTest extends TestCase {

  /**
   * @test JsonMessageSource::getMessageFilePath
   */
  public function testGetMessageFile() {
    $getMessageFilePath = function($category, $language) {
      /** @var JsonMessageSource $this */
      return $this->getMessageFilePath($category, $language);
    };

    it('should return the proper path to the message file', function() use ($getMessageFilePath) {
      $model = new JsonMessageSource(['basePath' => __DIR__.'/fixtures']);
      expect($getMessageFilePath->call($model, 'messages', 'fr'))->to->equal(str_replace('/', DIRECTORY_SEPARATOR, "{$model->basePath}/fr/messages.json"));
    });
  }

  /**
   * @test JsonMessageSource::jsonSerialize
   */
  public function testJsonSerialize() {
    it('should return a map with the same public values', function() {
      $data = (new JsonMessageSource(['basePath' => __DIR__.'/fixtures']))->jsonSerialize();
      expect($data)->to->have->property('basePath')->that->equal(__DIR__.'/fixtures');
      expect($data)->to->have->property('forceTranslation')->that->is->false;
    });
  }

  /**
   * @test JsonMessageSource::loadMessagesFromFile
   */
  public function testLoadMessagesFromFile() {
    $loadMessagesFromFile = function($messageFile) {
      /** @var JsonMessageSource $this */
      return $this->loadMessagesFromFile($messageFile);
    };

    it('should properly load the JSON source and parse it as array', function() use ($loadMessagesFromFile) {
      $model = new JsonMessageSource(['basePath' => __DIR__.'/fixtures']);
      expect($loadMessagesFromFile->call($model, "{$model->basePath}/fr/messages.json"))->to->equal(['Hello World!' => 'Bonjour le monde !']);
    });

    it('should enable proper translation of source strings', function() {
      $model = new JsonMessageSource(['basePath' => __DIR__.'/fixtures']);
      expect($model->translate('messages', 'Hello World!', 'fr'), 'Bonjour le monde !');
    });
  }

  /**
   * @test JsonMessageSource::__toString
   */
  public function testToString() {
    $model = (string) new JsonMessageSource(['basePath' => __DIR__.'/fixtures']);

    it('should start with the class name', function() use ($model) {
      expect($model)->to->startWith('yii\i18n\JsonMessageSource {');
    });

    it('should contain the instance properties', function() use ($model) {
      expect($model)->to->contain(sprintf('"basePath":"%s"', str_replace('\\', '\\\\', __DIR__.'/fixtures')))
        ->and->contain('"forceTranslation":false');
    });
  }
}
