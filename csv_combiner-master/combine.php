#!/usr/bin/env php
<?php
/**
 * CSV Combiner
 *
 * Programming Challenge
 *
 * @author Abinadi Ayerdis <abinadi@ayerdis.com>
 * @date 02-18-2016
 */

require 'vendor/autoload.php';

use Combiner\CsvCombiner;
use Symfony\Component\Console\Application;

// If the csv files are created/read on a Mac, the following is needed.
if (!ini_get("auto_detect_line_endings")) {
    ini_set("auto_detect_line_endings", '1');
}

// Instantiate and run the command
$app = new Application();
$app->add(new CsvCombiner());
$app->run();

