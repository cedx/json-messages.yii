<?php
/**
 * @file
 * Implementation of the `yii\i18n\JsonMessageSource` class.
 */
namespace yii\i18n;

// Dependencies.
use yii\helpers\FileHelper;
use yii\helpers\Json;

/**
 * Represents a message source that stores translated messages in JSON files.
 */
class JsonMessageSource extends PhpMessageSource {

  /**
   * Returns message file path for the specified language and category.
   * @param string $category The message category.
   * @param string $language The target language.
   * @return string The path to message file.
   */
  protected function getMessageFilePath($category, $language) {
    $path=preg_replace('/\.php$/i', '.json', parent::getMessageFilePath($category, $language));
    return FileHelper::normalizePath($path);
  }

  /**
   * Loads the message translation for the specified language and category.
   * @param string $messageFile string The path to message file.
   * @return array The message array or `null` if the file is not found.
   */
  protected function loadMessagesFromFile($messageFile) {
    if(!is_file($messageFile)) return null;
    $messages=Json::decode(@file_get_contents($messageFile));
    return is_array($messages) ? $messages : [];
  }
}
