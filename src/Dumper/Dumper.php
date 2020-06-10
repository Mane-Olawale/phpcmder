<?php

namespace PhpCmder\Dumper;

use PhpCmder\App;

abstract class Dumper
{
    protected $app;
    
    public function __construct( App $app )
    {
        $this->app = $app;
    }

    public function _dump(string $text, bool $bailOut = false){

        fwrite(STDERR, rtrim($text));
        $this->reset();
        if ($bailOut){
            $this->app->_bailOut();
        }
    }


    

    /**
     * reset the terminal color
     *
     * @param resource $channel file descriptor to write to
     *
     * @throws Exception
     */
    public function reset($channel = STDOUT)
    {
        fwrite(STDERR, "\33[0m\n");
    }


}