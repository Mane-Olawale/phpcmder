<?php

namespace PhpCmder\Dumper;


class ErrorDumper extends Dumper
{

    
    public function dump(string $tag, string $text, bool $bailOut = false)
    {
        $this->_dump("{$tag} {$text}", $bailOut);

    }

    

    public function error(string $var,  bool $bailOut = true)
    {
        $this->dump("Error:", $var, $bailOut);
    }

    

    public function warning(string $var,  bool $bailOut = false)
    {
        $this->dump("Warning:", $var, $bailOut);
    }



}