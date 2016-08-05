<?php

$srcRoot    = __DIR__ . '/src';
$vendorRoot = __DIR__ . '/vendor';

$phar = new Phar( __DIR__ . "/whilephar.phar",
                  FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME );

$phar['init.php'] = file_get_contents(__DIR__.'/init.php');

