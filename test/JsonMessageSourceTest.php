<?php
/**
 * Implementation of the `yii\test\i18n\JsonMessageSourceTest` class.
 */
namespace yii\test\i18n;

use PHPUnit\Framework\{TestCase};
use yii\helpers\{FileHelper};
use yii\i18n\{JsonMessageSource};

/**
 * @coversDefaultClass \yii\i18n\JsonMessageSource
 */
class JsonMessageSourceTest extends TestCase {

  /**
   * @var JsonMessageSource The data context of the tests.
   */
  private $model;

  /**
   * @test ::getMessageFilePath
   */
  public function testGetMessageFile() {
    $getMessageFilePath = function($category, $language) {
      return $this->getMessageFilePath($category, $language);
    };

    $expected = str_replace('/', DIRECTORY_SEPARATOR, "{$this->model->basePath}/fr/messages.json");
    $this->assertEquals($expected, $getMessageFilePath->call($this->model, 'messages', 'fr'));
  }

  /**
   * @test ::jsonSerialize
   */
  public function testJsonSerialize() {
    $data = $this->model->jsonSerialize();

    $this->assertObjectHasAttribute('basePath', $data);
    $this->assertEquals(__DIR__.'/fixtures', $data->basePath);

    $this->assertObjectHasAttribute('forceTranslation', $data);
    $this->assertFalse($data->forceTranslation);
  }

  /**
   * @test ::loadMessagesFromFile
   */
  public function testLoadMessagesFromFile() {
    $loadMessagesFromFile = function($messageFile) {
      return $this->loadMessagesFromFile($messageFile);
    };

    $expected = [ 'Hello World!' => 'Bonjour le monde !' ];
    $this->assertEquals($expected, $loadMessagesFromFile->call($this->model, "{$this->model->basePath}/fr/messages.json"));
    $this->assertEquals('Bonjour le monde !', $this->model->translate('messages', 'Hello World!', 'fr'));
  }

  /**
   * @test ::__toString
   */
  public function testToString() {
    $model = (string) $this->model;
    $this->assertStringStartsWith('yii\i18n\JsonMessageSource {', $model);
    $this->assertContains(sprintf('"basePath":"%s"', str_replace('\\', '\\\\', __DIR__.'/fixtures')), $model);
    $this->assertContains('"forceTranslation":false', $model);
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new JsonMessageSource(['basePath' => __DIR__.'/fixtures']);
  }
}
