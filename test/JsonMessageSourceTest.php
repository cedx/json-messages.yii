<?php
/**
 * Implementation of the `yii\test\i18n\JsonMessageSourceTest` class.
 */
namespace yii\test\i18n;
use yii\i18n\{JsonMessageSource};

/**
 * Tests the features of the `yii\i18n\JsonMessageSource` class.
 */
class JsonMessageSourceTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var JsonMessageSource The data context of the tests.
   */
  private $model;

  /**
   * Tests the `JsonMessageSource::getMessageFilePath()` method.
   */
  public function testGetMessageFile() {
    $getMessageFilePath = function($category, $language) {
      return $this->getMessageFilePath($category, $language);
    };

    $expected = str_replace('/', DIRECTORY_SEPARATOR, "{$this->model->basePath}/fr/messages.json");
    $this->assertEquals($expected, $getMessageFilePath->call($this->model, 'messages', 'fr'));
  }

  /**
   * Tests the `JsonMessageSource::loadMessagesFromFile()` method.
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
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new JsonMessageSource();
    $this->model->basePath = __DIR__;
  }
}
