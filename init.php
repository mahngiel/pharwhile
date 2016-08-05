<?php

if ( !isset( $argv ) ) {
    die( "called without args" );
}

require __DIR__ . '/vendor/autoload.php';

$whoops = new \Whoops\Run();
$whoops->pushHandler( new \Whoops\Handler\JsonResponseHandler() );
$whoops->register();

$fs = new \Symfony\Component\Filesystem\Filesystem();

$config = $argv[1];

if ( !$fs->exists( $config ) ) {
    throw new \Symfony\Component\Filesystem\Exception\FileNotFoundException( $config );
}

( new \Dotenv\Dotenv( dirname( $config ), sprintf( "%s", basename( $config ) ) ) )->load();

\Mahngiel\PharWhile\App::run();
