#!/usr/bin/env php
<?php
/**
 * @file
 * Creates a distribution file for this program.
 */

chdir(dirname(__DIR__));

$archive=new ZipArchive();
$archive->open('var/json-messages.yii-0.4.0.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);
$archive->addGlob('*.{json,md,txt}', GLOB_BRACE);
$archive->addGlob('lib/**/*.php');
$archive->close();
