<?php

use Humbug\SelfUpdate\Updater;

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

$updater = new Updater( );
$updater->getStrategy()->setPharUrl( 'https://mahngiel.github.io/pharwhile/while.phar' );
$updater->getStrategy()->setVersionUrl( 'https://mahngiel.github.io/pharwhile/while.phar.version' );

try {
    $result = $updater->hasUpdate();
    if ( $result ) {
        echo( sprintf(
            'The current stable build available remotely is: %s',
            $updater->getNewVersion()
        ) );
    }
    elseif ( false === $updater->getNewVersion() ) {
        echo( 'There are no stable builds available.' );
    }
    else {
        echo( 'You have the current stable build installed.' );
    }
}
catch ( \Exception $e ) {
    printf($e->getMessage());
    exit( 'Well, something happened! Either an oopsie or something involving hackers.' );
}

