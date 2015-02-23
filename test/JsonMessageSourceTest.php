<?php
/**
 * Implementation of the `yii\test\i18n\JsonMessageSourceTest` class.
 * @module test.i18n.JsonMessageSourceTest
 */
namespace yii\tests\i18n;
use yii\i18n\JsonMessageSource;

/**
 * Publicly exposes the features of the `JsonMessageSource` class.
 * @class yii.test.i18n.JsonMessageSourceStub
 * @extends yii.i18n.JsonMessageSource
 * @constructor
 */
class JsonMessageSourceStub extends JsonMessageSource {
  public function getMessageFilePath($category, $language) {
    return parent::getMessageFilePath($category, $language);
  }
  public function loadMessagesFromFile($messageFile) {
    return parent::loadMessagesFromFile($messageFile);
  }
}

/**
 * Tests the features of the `yii\i18n\JsonMessageSource` class.
 * @class yii.test.i18n.JsonMessageSourceTest
 * @extends phpunit.PHPUnit_Framework_TestCase
 * @constructor
 */
class JsonMessageSourceTest extends \PHPUnit_Framework_TestCase {

  /**
   * The data context of the tests.
   * @property model
   * @type yii.i18n.JsonMessageSource
   * @private
   */
  private $model;

  /**
   * Tests the `getMessageFilePath` method.
   * @method testGetMessageFilePath
   */
  public function testGetMessageFile() {
    $expected=str_replace('/', DIRECTORY_SEPARATOR, $this->model->basePath.'/fr/messages.json');
    $this->assertEquals($expected, $this->model->getMessageFilePath('messages', 'fr'));
  }

  /**
   * Tests the `loadMessagesFromFile` method.
   * @method testLoadMessages
   */
  public function testLoadMessagesFromFile() {
    $expected=[ 'Hello World!'=>'Bonjour le monde !' ];
    $this->assertEquals($expected, $this->model->loadMessagesFromFile($this->model->basePath.'/fr/messages.json'));
    $this->assertEquals('Bonjour le monde !', $this->model->translate('messages', 'Hello World!', 'fr'));
  }

  /**
   * Performs a common set of tasks just before each test method is called.
   * @method setUp
   * @protected
   */
  protected function setUp() {
    $this->model=new JsonMessageSourceStub();
    $this->model->basePath=__DIR__;
  }
}
