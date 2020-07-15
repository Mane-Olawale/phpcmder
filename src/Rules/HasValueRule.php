<?php 

namespace Phpcmder\Rules;

class HasValueRule extends Rule 
{
    public $key = 'hasValue';

    public $scope = [
        'command'
    ];

    public $withValue = true;

    public function check( $value )
    {
        if ($this->current()){
            $this->command->has
        }
    }
}