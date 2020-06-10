<?php

namespace PhpCmder\Chain;

use PhpCmder\Argument;


class ChainNode
{
    private $upNode = null;

    private $downNode = null;

    private $argument = null;

    public function __construct(string $arg)
    {
        $this->argument = new Argument($arg);
    }


    public function setUpNode(self $var)
    {
        $this->upNode = $var;
    }


    public function setDownNode(self $var)
    {
        $this->downNode = $var;
    }


    public function getUpNode()
    {
        return $this->upNode;
    }


    public function getDownNode()
    {
        return $this->downNode;
    }


    public function getArgument()
    {
        return $this->argument;
    }

    
}
