#!/usr/bin/env php
<?php
/**
 * @file
 * Deletes all generated files and reset any saved state.
 */

chdir(dirname(__DIR__));
@unlink('var/json-messages.yii-0.4.0.zip');
