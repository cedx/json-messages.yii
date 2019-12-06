<?php declare(strict_types=1);
namespace yii\i18n;

/** Represents a message source that stores translated messages in PHP files. */
class ExtendedPhpMessageSource extends FileMessageSource {

  /** @var string The extension of the PHP files. */
  public string $fileExtension = 'php';

  /**
   * Parses the translations contained in the specified input data.
   * @param string $messageData The input data.
   * @return array<string, array|string> The translations contained in the specified input data.
   */
  protected function parseMessages(string $messageData): array {
    return is_array($messages = eval("?>$messageData")) ? $messages : [];
  }
}
