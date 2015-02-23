<?php
/**
 * Implementation of the `belin\i18n\JsonMessageSource` class.
 * @module i18n.JsonMessageSource
 */
namespace belin\i18n;

use yii\helpers\Json;
use yii\i18n\PhpMessageSource;

/**
 * Represents a message source that stores translated messages in JSON files.
 * @class belin.i18n.JsonMessageSource
 * @extends yii.i18n.PhpMessageSource
 * @constructor
 */
class JsonMessageSource extends PhpMessageSource {

  /**
   * Returns message file path for the specified language and category.
   * @method getMessageFilePath
   * @param {string} $category The message category.
   * @param {string} $language The target language.
   * @return {string} The path to message file.
   * @protected
   */
  protected function getMessageFilePath($category, $language) {
    return preg_replace('/\.php$/i', '.json', parent::getMessageFilePath($category, $language));
  }

  /**
   * Loads the message translation for the specified language and category or returns null if file doesn't exist.
   * @method loadMessagesFromFile
   * @param {string} $messageFile string The path to message file.
   * @return {array} The message array or `null` if the file is not found.
   * @protected
   */
  protected function loadMessagesFromFile($messageFile) {
    if(!is_file($messageFile)) return null;
    $messages=Json::decode(file_get_contents($messageFile));
    return is_array($messages) ? $messages : [];
  }
}
