<?php
/**
 * Implementation of the `tests.CJsonMessageSourceTest` class.
 * @module test.CJsonMessageSourceTest
 */
Yii::import('application.CJsonMessageSource');

/**
 * Publicly exposes the features of the `CJsonMessageSource` class.
 * @class tests.CJsonMessageSourceStub
 * @extends CJsonMessageSource
 * @constructor
 */
class CJsonMessageSourceStub extends CJsonMessageSource {
  public function getMessageFile($category, $language) {
    return parent::getMessageFile($category, $language);
  }
  public function loadMessages($category, $language) {
    return parent::loadMessages($category, $language);
  }
}

/**
 * Tests the features of the `CJsonMessageSource` class.
 * @class tests.CJsonMessageSourceTest
 * @extends system.test.CTestCase
 * @constructor
 */
class CJsonMessageSourceTest extends CTestCase {

  /**
   * The data context of the tests.
   * @property model
   * @type CJsonMessageSource
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
    $this->model=new CJsonMessageSourceStub();
    $this->model->basePath=__DIR__;
    $this->model->cacheID=false;
  }
}
