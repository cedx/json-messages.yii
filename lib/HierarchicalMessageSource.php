<?php
declare(strict_types=1);
namespace yii\i18n;

use yii\base\{InvalidArgumentException};
use yii\helpers\{FileHelper};

/**
 * Represents a message source that stores translated messages in YAML files.
 */
abstract class HierarchicalMessageSource extends PhpMessageSource {

  /**
   * @var bool Value indicating whether nested YAML objects are enabled.
   */
  public $enableNesting = false;

  /**
   * @var string TODO !!! description
   */
  public $fileExtension = 'php';

  /**
   * @var string The string used to delimit properties of nested YAML objects.
   */
  public $nestingSeparator = '.';

  /**
   * Returns message file path for the specified language and category.
   * @param string $category The message category.
   * @param string $language The target language.
   * @return string The path to message file.
   */
  protected function getMessageFilePath($category, $language): string {
    $path = preg_replace('/\.php$/i', ".{$this->fileExtension}", parent::getMessageFilePath($category, $language));
    return FileHelper::normalizePath($path);
  }

  /**
   * Loads the message translation for the specified language and category.
   * @param string $messageFile string The path to message file.
   * @return string[] The message array, or an empty array if the file is not found or invalid.
   */
  protected function loadMessagesFromFile($messageFile): array {
    if (!is_file($messageFile)) return [];
    $messages = $this->parseMessages(@file_get_contents($messageFile));
    return $this->enableNesting ? $this->flatten($messages) : $messages;
  }

  /**
   * TODO
   * @param string $messageData
   * @return array
   */
  abstract protected function parseMessages(string $messageData): array;

  /**
   * Flattens a multidimensional array into a single array where the keys are property paths to the contained scalar values.
   * @param array $array The input array.
   * @return array The flattened array.
   */
  protected function flatten(array $array): array {
    $flatMap = [];

    $iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array), \RecursiveIteratorIterator::SELF_FIRST);
    foreach ($iterator as $key => $value) {
      if (!$iterator->callHasChildren()) {
        $path = [];
        for ($i = 0, $length = $iterator->getDepth(); $i <= $length; $i++) $path[] = $iterator->getSubIterator($i)->key();
        $flatMap[implode($this->nestingSeparator, $path)] = $value;
      }
    }

    return $flatMap;
  }
}
