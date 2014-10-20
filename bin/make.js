#!/usr/bin/env node
/* global cd, config, cp, echo, exec, rm, target */

/**
 * Build system.
 * @module bin.make
 */
'use strict';

// Module dependencies.
require('shelljs/make');
var archiver=require('archiver');
var fs=require('fs');
var pkg=require('../package.json');
var util=require('util');

/**
 * Provides tasks for [ShellJS](http://shelljs.org) make tool.
 * @class cli.Makefile
 * @static
 */
cd(__dirname+'/..');

/**
 * The application settings.
 * @property config
 * @type Object
 */
config.fatal=true;
config.output=util.format('var/%s-%s.zip', pkg.yuidoc.name.toLowerCase(), pkg.version);

/**
 * Runs the default tasks.
 * @method all
 */
target.all=function() {
  echo('Please specify a target. Available targets:');
  for(var task in target) {
    if(task!='all') echo(' ', task);
  }
};

/**
 * Checks the package dependencies.
 * @method check
 */
target.check=function() {
  echo('Check the package dependencies...');
  exec('david');
};

/**
 * Deletes all generated files and reset any saved state.
 * @method clean
 */
target.clean=function() {
  echo('Delete the output files...');
  rm('-f', config.output);
};

/**
 * Creates a distribution file for this program.
 * @method dist
 */
target.dist=function() {
  echo('Build the redistributable...');

  var sources=[
    'composer.json',
    '*.md',
    '*.txt',
    'lib/*.php'
  ];

  var archive=archiver('zip');
  archive.on('entry', function(entry) { echo('Pack:', entry.name); });
  archive.pipe(fs.createWriteStream(config.output));
  archive.bulk({ src: sources }).finalize();
};

/**
 * Builds the documentation.
 * @method doc
 */
target.doc=function() {
  echo('Build the documentation...');
  exec('docgen');
  cp('-f', [ 'www/apple-touch-icon.png', 'www/favicon.ico' ], 'doc/api/assets');
};

/**
 * Performs static analysis of source code.
 * @method lint
 */
target.lint=function() {
  config.fatal=false;

  echo('Static analysis of JavaScript sources...');
  exec('jshint --verbose bin');

  echo('Static analysis of documentation comments...');
  exec('docgen --lint');

  config.fatal=true;
};
