<?php declare(strict_types=1);
namespace yii\i18n;

use yii\helpers\{Json};

/** Represents a message source that stores translated messages in JSON files. */
class JsonMessageSource extends FileMessageSource {

  /** @var string The extension of the JSON files. */
  public string $fileExtension = 'json';

  /**
   * Parses the translations contained in the specified input data.
   * @param string $messageData The input data.
   * @return array<string, array|string> The translations contained in the specified input data.
   */
  protected function parseMessages(string $messageData): array {
    return is_array($messages = Json::decode($messageData)) ? $messages : [];
  }
}
