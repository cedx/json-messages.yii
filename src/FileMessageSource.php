<?php declare(strict_types=1);
namespace yii\i18n;

use yii\helpers\FileHelper;

/** Provides the base class for a message source that stores translated messages in files. */
abstract class FileMessageSource extends PhpMessageSource {

	/** @var bool Value indicating whether nested objects are enabled. */
	public bool $enableNesting = false;

	/** @var string The extension of the message files. */
	public string $fileExtension = "";

	/** @var string The string used to delimit properties of nested objects. */
	public string $nestingSeparator = ".";

	/** Initializes this object. */
	function init(): void {
		parent::init();
		if ($this->enableNesting) $this->forceTranslation = true;
	}

	/**
	 * Returns message file path for the specified language and category.
	 * @param string $category The message category.
	 * @param string $language The target language.
	 * @return string The path to message file.
	 */
	protected function getMessageFilePath($category, $language): string {
		assert(is_string($category) && mb_strlen($category) > 0);
		assert(is_string($language) && mb_strlen($language) > 0);
		$path = parent::getMessageFilePath($category, $language);
		return FileHelper::normalizePath((string) preg_replace('/\.php$/i', ".{$this->fileExtension}", $path));
	}

	/**
	 * Loads the message translation for the specified language and category.
	 * @param string $messageFile string The path to message file.
	 * @return array<string, string>|null The message array, or a `null` reference if the file is not found.
	 */
	protected function loadMessagesFromFile($messageFile): ?array {
		assert(is_string($messageFile) && mb_strlen($messageFile) > 0);

		$file = new \SplFileObject($messageFile);
		if (!$file->isReadable()) return null;
		$messages = $this->parseMessages((string) $file->fread($file->getSize()));
		return $this->enableNesting ? $this->flatten($messages) : $messages; // @phpstan-ignore-line
	}

	/**
	 * Parses the translations contained in the specified input data.
	 * @param string $messageData The input data.
	 * @return array<string, array|string> The translations contained in the specified input data.
	 */
	abstract protected function parseMessages(string $messageData): array;

	/**
	 * Flattens a multidimensional array into a single array where the keys are property paths to the contained scalar values.
	 * @param array<string, array|string> $array The input array.
	 * @return array<string, string> The flattened array.
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
