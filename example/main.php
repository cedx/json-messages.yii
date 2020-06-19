<?php declare(strict_types=1);
use yii\i18n\JsonMessageSource;

/** Translates a message. */
function main(): void {
	$i18n = Yii::$app->getI18n();

	// Using flat mapping.
	$i18n->translations["app*"] = new JsonMessageSource;
	print Yii::t("app", "FooBarBaz");

	// Using nested objects.
	$i18n->translations["app*"] = new JsonMessageSource(["enableNesting" => true]);
	print Yii::t("app", "foo.bar.baz");
}
