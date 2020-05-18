<?php declare(strict_types=1);
namespace yii\i18n;

use PHPUnit\Framework\{TestCase};
use function PHPUnit\Framework\{assertThat, equalTo, isEmpty};

/** @testdox yii\i18n\ExtendedPhpMessageSource */
class ExtendedPhpMessageSourceTest extends TestCase {

	/** @var \ReflectionClass<ExtendedPhpMessageSource> The object used to change the visibility of inaccessible class members. */
	private static \ReflectionClass $reflection;

	/** @beforeClass This method is called before the first test of this test class is run. */
	static function setUpBeforeClass(): void {
		self::$reflection = new \ReflectionClass(ExtendedPhpMessageSource::class);
	}

	/** @testdox ->flatten() */
	function testFlatten(): void {
		$method = self::$reflection->getMethod("flatten");
		$method->setAccessible(true);

		// It should merge the keys of a multidimensional array.
		$model = new ExtendedPhpMessageSource;
		assertThat($method->invoke($model, []), equalTo([]));
		assertThat($method->invoke($model, ["foo" => "bar", "baz" => "qux"]), equalTo(["foo" => "bar", "baz" => "qux"]));
		assertThat($method->invoke($model, ["foo" => ["bar" => "baz"]]), equalTo(["foo.bar" => "baz"]));

		$source = [
			"foo" => "bar",
			"bar" => ["baz" => "qux"],
			"baz" => ["qux" => [
				"foo" => "bar",
				"bar" => "baz"
			]]
		];

		assertThat($method->invoke($model, $source), equalTo([
			"foo" => "bar",
			"bar.baz" => "qux",
			"baz.qux.foo" => "bar",
			"baz.qux.bar" => "baz"
		]));

		// It should allow different nesting separators.
		$source = [
			"foo" => "bar",
			"bar" => ["baz" => "qux"],
			"baz" => ["qux" => [
				"foo" => "bar",
				"bar" => "baz"
			]]
		];

		$model = new ExtendedPhpMessageSource(["nestingSeparator" => "/"]);
		assertThat($method->invoke($model, $source), equalTo([
			"foo" => "bar",
			"bar/baz" => "qux",
			"baz/qux/foo" => "bar",
			"baz/qux/bar" => "baz"
		]));

		$model = new ExtendedPhpMessageSource(["nestingSeparator" => "->"]);
		assertThat($method->invoke($model, $source), equalTo([
			"foo" => "bar",
			"bar->baz" => "qux",
			"baz->qux->foo" => "bar",
			"baz->qux->bar" => "baz"
		]));
	}

	/** @testdox ->getMessageFilePath() */
	function testGetMessageFilePath(): void {
		$method = self::$reflection->getMethod("getMessageFilePath");
		$method->setAccessible(true);

		// It should return the proper path to the message file.
		$model = new ExtendedPhpMessageSource(["basePath" => "@root/test/fixtures"]);
		$messageFile = str_replace("/", DIRECTORY_SEPARATOR, __DIR__."/fixtures/fr/messages.php");
		assertThat($method->invoke($model, "messages", "fr"), equalTo($messageFile));

		// It should should support different file extensions.
		$model = new ExtendedPhpMessageSource(["basePath" => "@root/test/fixtures", "fileExtension" => "php7"]);
		$messageFile = str_replace("/", DIRECTORY_SEPARATOR, __DIR__."/fixtures/fr/messages");
		assertThat($method->invoke($model, "messages", "fr"), equalTo("$messageFile.php7"));
	}

	/** @testdox ->loadMessagesFromFile() */
	function testLoadMessagesFromFile(): void {
		$method = self::$reflection->getMethod("loadMessagesFromFile");
		$method->setAccessible(true);

		// It should properly load the JSON source and parse it as array.
		$model = new ExtendedPhpMessageSource(["basePath" => "@root/test/fixtures", "enableNesting" => true]);
		$messageFile = \Yii::getAlias("{$model->basePath}/fr/messages.php");
		assertThat($method->invoke($model, $messageFile), equalTo([
			"Hello World!" => "Bonjour le monde !",
			"foo.bar.baz" => "FooBarBaz"
		]));

		// It should enable proper translation of source strings.
		$model = new ExtendedPhpMessageSource(["basePath" => "@root/test/fixtures", "enableNesting" => true]);
		assertThat($model->translate("messages", "Hello World!", "fr"), equalTo("Bonjour le monde !"));
		assertThat($model->translate("messages", "foo.bar.baz", "fr"), equalTo("FooBarBaz"));

		$model = new ExtendedPhpMessageSource(["basePath" => "@root/test/fixtures", "enableNesting" => true, "nestingSeparator" => "/"]);
		assertThat($model->translate("messages", "foo/bar/baz", "fr"), equalTo("FooBarBaz"));
	}

	/** @testdox ->parseMessages() */
	function testParseMessages(): void {
		$method = self::$reflection->getMethod("parseMessages");
		$method->setAccessible(true);

		// It should parse a PHP file as a hierarchical array.
		$model = new ExtendedPhpMessageSource(["basePath" => "@root/test/fixtures", "enableNesting" => true]);
		$file = new \SplFileObject((string) \Yii::getAlias("{$model->basePath}/fr/messages.php"));
		assertThat($method->invoke($model, (string) $file->fread($file->getSize())), equalTo([
			"Hello World!" => "Bonjour le monde !",
			"foo" => ["bar" => ["baz" => "FooBarBaz"]]
		]));

		// It should parse an invalid PHP file as an empty array.
		$model = new ExtendedPhpMessageSource(["basePath" => "@root/test/fixtures"]);
		assertThat($method->invoke($model, '<?php return ["foo", "bar"];'), isEmpty());
	}
}
