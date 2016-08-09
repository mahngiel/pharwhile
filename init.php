<?php

if ( !isset( $argv ) ) {
    die( "called without args" );
}

require __DIR__ . '/vendor/autoload.php';

$whoops = new \Whoops\Run();
$whoops->pushHandler( new \Whoops\Handler\JsonResponseHandler() );
$whoops->register();

$config = pathinfo( $argv[0] )['extension'] === 'phar' ? $argv[1] : __DIR__ . '/.env';

$fs = new \Symfony\Component\Filesystem\Filesystem();

if ( !$fs->exists( $config ) ) {
    throw new \Symfony\Component\Filesystem\Exception\FileNotFoundException( $config );
}

( new \Dotenv\Dotenv( dirname( $config ), sprintf( "%s", basename( $config ) ) ) )->load();

\Mahngiel\PharWhile\App::run();
