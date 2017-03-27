<?php
namespace yii\i18n;
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
      return $this->getMessageFilePath($category, $language);
    };

    it('should...', function() {

    });

    $model = new JsonMessageSource(['basePath' => __DIR__.'/fixtures']);
    expect($getMessageFilePath->call($model, 'messages', 'fr'))->to->equal(str_replace('/', DIRECTORY_SEPARATOR, "{$model->basePath}/fr/messages.json"));
  }

  /**
   * @test JsonMessageSource::jsonSerialize
   */
  public function testJsonSerialize() {

    it('should...', function() {

    });

    $data = (new JsonMessageSource(['basePath' => __DIR__.'/fixtures']))->jsonSerialize();
    expect($data)->to->have->property('basePath')->that->equal(__DIR__.'/fixtures');
    expect($data)->to->have->property('forceTranslation')->that->is->false;
  }

  /**
   * @test JsonMessageSource::loadMessagesFromFile
   */
  public function testLoadMessagesFromFile() {
    $loadMessagesFromFile = function($messageFile) {
      return $this->loadMessagesFromFile($messageFile);
    };

    it('should...', function() {

    });

    $model = new JsonMessageSource(['basePath' => __DIR__.'/fixtures']);
    expect($loadMessagesFromFile->call($model, "{$model->basePath}/fr/messages.json"))->to->equal(['Hello World!' => 'Bonjour le monde !']);
    expect($model->translate('messages', 'Hello World!', 'fr'), 'Bonjour le monde !');
  }

  /**
   * @test JsonMessageSource::__toString
   */
  public function testToString() {
    $model = (string) new JsonMessageSource(['basePath' => __DIR__.'/fixtures']);

    it('should...', function() {

    });

    $this->assertStringStartsWith('yii\i18n\JsonMessageSource {', $model);
    $this->assertContains(sprintf('"basePath":"%s"', str_replace('\\', '\\\\', __DIR__.'/fixtures')), $model);
    $this->assertContains('"forceTranslation":false', $model);
  }
}
