<?php
/**
 * Implementation of the `yii\test\i18n\JsonMessageSourceTest` class.
 */
namespace yii\test\i18n;
use yii\i18n\{JsonMessageSource};

/**
 * Publicly exposes the features of the `yii\i18n\JsonMessageSource` class.
 */
class JsonMessageSourceStub extends JsonMessageSource {

  /**
   * Returns message file path for the specified language and category.
   * @param string $category The message category.
   * @param string $language The target language.
   * @return string The path to message file.
   */
  public function getMessageFilePath($category, $language): string {
    return parent::getMessageFilePath($category, $language);
  }

  /**
   * Loads the message translation for the specified language and category.
   * @param string $messageFile string The path to message file.
   * @return string[] The message array or `null` if the file is not found.
   */
  public function loadMessagesFromFile($messageFile): array {
    return parent::loadMessagesFromFile($messageFile);
  }
}

/**
 * Tests the features of the `yii\i18n\JsonMessageSource` class.
 */
class JsonMessageSourceTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var JsonMessageSourceStub The data context of the tests.
   */
  private $model;

  /**
   * Tests the `getMessageFilePath` method.
   */
  public function testGetMessageFile() {
    $expected = str_replace('/', DIRECTORY_SEPARATOR, $this->model->basePath . '/fr/messages.json');
    $this->assertEquals($expected, $this->model->getMessageFilePath('messages', 'fr'));
  }

  /**
   * Tests the `loadMessagesFromFile` method.
   */
  public function testLoadMessagesFromFile() {
    $expected = [ 'Hello World!' => 'Bonjour le monde !' ];
    $this->assertEquals($expected, $this->model->loadMessagesFromFile($this->model->basePath . '/fr/messages.json'));
    $this->assertEquals('Bonjour le monde !', $this->model->translate('messages', 'Hello World!', 'fr'));
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   */
  protected function setUp() {
    $this->model = new JsonMessageSourceStub();
    $this->model->basePath = __DIR__;
  }
}
