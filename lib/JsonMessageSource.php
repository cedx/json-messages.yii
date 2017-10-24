<?php
declare(strict_types=1);
namespace yii\i18n;

use yii\helpers\{FileHelper, Json};

/**
 * Represents a message source that stores translated messages in JSON files.
 */
class JsonMessageSource extends PhpMessageSource implements \JsonSerializable {

  /**
   * @var bool Value indicating whether nested JSON objects are enabled.
   */
  public $enableNesting = false;

  /**
   * @var string The string used to delimit properties of nested JSON objects.
   */
  public $nestingSeparator = '.';

  /**
   * Returns a string representation of this object.
   * @return string The string representation of this object.
   */
  public function __toString(): string {
    $json = Json::encode($this);
    return static::class." $json";
  }

  /**
   * Converts this object to a map in JSON format.
   * @return \stdClass The map in JSON format corresponding to this object.
   */
  public function jsonSerialize(): \stdClass {
    return (object) [
      'basePath' => $this->basePath,
      'fileMap' => $this->fileMap,
      'forceTranslation' => $this->forceTranslation,
      'sourceLanguage' => $this->sourceLanguage
    ];
  }

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
    if (!is_array($messages)) return [];

    return $this->enableNesting ? $this->flatten($messages) : $messages;
  }

  /**
   * Flattens a multidimensional array into a single array where the keys are property paths to the contained scalar values.
   * @param array $array The input array.
   * @return array The flattened array.
   */
  private function flatten(array $array): array {
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
