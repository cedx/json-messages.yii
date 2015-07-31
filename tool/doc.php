#!/usr/bin/env php
<?php
/**
 * @file
 * Builds the documentation.
 */

chdir(dirname(__DIR__));

echo shell_exec(sprintf(
  '%s %s',
  PHP_OS=='WINNT' ? '"C:\Program Files\Doxygen\bin\doxygen.exe"' : 'doxygen',
  'doc'.DIRECTORY_SEPARATOR.'api.doxyfile'
));

copy('web/favicon.ico', 'doc/api/favicon.ico');
