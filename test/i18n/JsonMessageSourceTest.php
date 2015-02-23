<?php
/**
 * Implementation of the `belin\test\i18n\JsonMessageSourceTest` class.
 * @module test.i18n.JsonMessageSourceTest
 */
namespace belin\tests\i18n;
use belin\i18n\JsonMessageSource;

/**
 * Publicly exposes the features of the `JsonMessageSource` class.
 * @class belin.test.i18n.JsonMessageSourceStub
 * @extends belin.i18n.JsonMessageSource
 * @constructor
 */
class JsonMessageSourceStub extends JsonMessageSource {
  public function getMessageFile($category, $language) {
    return parent::getMessageFile($category, $language);
  }
  public function loadMessages($category, $language) {
    return parent::loadMessages($category, $language);
  }
}

/**
 * Tests the features of the `belin\i18n\JsonMessageSource` class.
 * @class belin.test.i18n.JsonMessageSourceTest
 * @extends system.test.CTestCase
 * @constructor
 */
class JsonMessageSourceTest extends \CTestCase {

  /**
   * The data context of the tests.
   * @property model
   * @type belin.i18n.JsonMessageSource
   * @private
   */
  private $model;

  /**
   * Tests the `getMessageFile` method.
   * @method testGetMessageFile
   */
  public function testGetMessageFile() {
    $expected=str_replace('/', DIRECTORY_SEPARATOR, $this->model->basePath.'/fr/messages.json');
    $this->assertEquals($expected, $this->model->getMessageFile('messages', 'fr'));
  }

  /**
   * Tests the `loadMessages` method.
   * @method testLoadMessages
   */
  public function testLoadMessages() {
    $expected=[ 'Hello World!'=>'Bonjour le monde !' ];
    $this->assertEquals($expected, $this->model->loadMessages('messages', 'fr'));
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
    $this->model->cacheID=false;
  }
}
