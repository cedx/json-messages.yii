<?php
/**
 * Implementation of the `belin\i18n\JsonMessageSource` class.
 * @module i18n.JsonMessageSource
 */
namespace belin\i18n;

/**
 * Represents a message source that stores translated messages in JSON files.
 * @class belin.i18n.JsonMessageSource
 * @extends system.i18n.CPhpMessageSource
 * @constructor
 */
class JsonMessageSource extends \CPhpMessageSource {

  /**
   * The string prefixed to every cache key in order to avoid name collisions.
   * @property CACHE_KEY_PREFIX
   * @type string
   * @static
   * @final
   */
  const CACHE_KEY_PREFIX='belin.i18n.JsonMessageSource:';

  /**
   * Determines the message file name based on the given category and language.
   * @method getMessageFile
   * @param {string} $category The category name.
   * @param {string} $language The language ID.
   * @return {string} The path of the message file.
   * @protected
   */
  protected function getMessageFile($category, $language) {
    return preg_replace('/\.php$/i', '.json', parent::getMessageFile($category, $language));
  }

  /**
   * Loads the message translation for the specified language and category.
   * @method loadMessages
   * @param {string} $category The message category.
   * @param {string} $language The target language.
   * @return {array} The loaded messages.
   * @protected
   */
  protected function loadMessages($category, $language) {
    $messageFile=$this->getMessageFile($category, $language);

    $cache=($this->cacheID===false ? null : \Yii::app()->getComponent($this->cacheID));
    $cacheKey=static::CACHE_KEY_PREFIX.$messageFile;
    if($cache && $this->cachingDuration>0) {
      $data=$cache->get($cacheKey);
      if($data!==false) return unserialize($data);
    }

    $messages=(is_file($messageFile) ? \CJSON::decode(file_get_contents($messageFile)) : []);
    if(!is_array($messages)) $messages=[];

    if($cache) {
      $dependency=new \CFileCacheDependency($messageFile);
      $cache->set($cacheKey, serialize($messages), $this->cachingDuration, $dependency);
    }

    return $messages;
  }
}
