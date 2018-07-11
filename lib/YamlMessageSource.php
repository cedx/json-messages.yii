<?php
declare(strict_types=1);
namespace yii\i18n;

use Symfony\Component\Yaml\{Yaml};

/**
 * Represents a message source that stores translated messages in YAML files.
 */
class YamlMessageSource extends HierarchicalMessageSource {

  /**
   * @var string TODO !!! description
   */
  public $fileExtension = 'yaml';

  /**
   * TODO
   * @param string $messageData
   * @return array
   */
  protected function parseMessages(string $messageData): array {
    return is_array($messages = Yaml::parse($messageData)) ? $messages : [];
  }
}
