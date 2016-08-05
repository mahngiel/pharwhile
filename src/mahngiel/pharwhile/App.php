<?php namespace Mahngiel\PharWhile;

class App
{
    public static function run()
    {
        $i = 0;
        while ( $i < getenv('COUNTER') ) {
            $i++;
            echo "$i\n";
            sleep( 1 );
        }
    }
}
