<?php declare(strict_types=1);
namespace yii\i18n;

use Symfony\Component\Yaml\{Yaml};

/** Represents a message source that stores translated messages in YAML files. */
class YamlMessageSource extends FileMessageSource {

  /** @var string The extension of the YAML files. */
  public string $fileExtension = 'yaml';

  /**
   * Parses the translations contained in the specified input data.
   * @param string $messageData The input data.
   * @return array<string, array|string> The translations contained in the specified input data.
   */
  protected function parseMessages(string $messageData): array {
    return is_array($messages = Yaml::parse($messageData)) ? $messages : [];
  }
}
