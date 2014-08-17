<?php

require_once __DIR__ . '/../vendor/autoload.php';

use cloak\Analyzer;
use cloak\ConfigurationBuilder;
use cloak\reporter\CompositeReporter;
use cloak\reporter\ProcessingTimeReporter;
use cloak\reporter\MarkdownReporter;
use cloak\result\File;

$analyzer = Analyzer::factory(function(ConfigurationBuilder $builder) {

    $builder->reporter(new CompositeReporter([
        new MarkdownReporter(__DIR__ . '/report.md'),
        new ProcessingTimeReporter()
    ]));

    $builder->includeFile(function(File $file) {
        return $file->matchPath('/src');
    })->excludeFile(function(File $file) {
        return $file->matchPath('/spec') || $file->matchPath('/vendor');
    });

});

$analyzer->start();

$argv = array('../vendor/bin/pho');
require_once __DIR__ . "/../vendor/bin/pho";

$analyzer->stop();
