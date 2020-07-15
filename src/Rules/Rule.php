<?php

namespace Phpcmder\Rules;

use Phpcmder\Controller as Command;


abstract class Rule 
{
    protected $command;

    protected $rule;

    protected $currentScope = 'command';

    public function __construct(Command $command, $value )
    {
        $this->command = $command;

        $this->value = $value;
    }

    public function current(string $scope = 'command' )
    {
        return $scope === $this->currentScope;
    }

    abstract public function check() : void;

}
