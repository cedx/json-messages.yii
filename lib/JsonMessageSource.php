<?php
/**
 * Implementation of the `yii\i18n\JsonMessageSource` class.
 */
namespace yii\i18n;
use yii\helpers\{FileHelper, Json};

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
  protected function getMessageFilePath($category, $language): string {
    $path = preg_replace('/\.php$/i', '.json', parent::getMessageFilePath($category, $language));
    return FileHelper::normalizePath($path);
  }

  /**
   * Loads the message translation for the specified language and category.
   * @param string $messageFile string The path to message file.
   * @return string[] The message array, or an empty array if the file is not found or invalid.
   */
  protected function loadMessagesFromFile($messageFile): array {
    if (!is_file($messageFile)) return [];
    $messages = Json::decode(@file_get_contents($messageFile));
    return is_array($messages) ? $messages : [];
  }
}
