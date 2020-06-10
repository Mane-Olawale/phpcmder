<?php

namespace PhpCmder;

class Argument
{


    private $raw;
    
    private $key;

    private $type;

    private $hasValue = false;

    private $value = null;

    private $valueType = null;


    public function __construct(string $var)
    {
        if (substr($var, 0, 2) === '--') {

            $this->type = 'option';
            $this->key = trim($var, '--');

        }else if (substr($var, 0, 1) === '-'){

            $this->type = 'var';
            $this->key = trim($var, '-');

        }else if (strpos($var, ' ')){

            $this->type = 'string';
            $this->key = $var;

        }else if (is_numeric($var)){

            $this->type = 'numeric';
            $this->key = $var;

        }else{

            $this->type = 'plain';
            $this->key = $var;

        }

        $this->raw = $var;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function setValue( string $var )
    {
        $this->value = $var;

        
        if (strpos($var, ' ')){

            $this->valueType = 'string';

        }else if (is_numeric($var)){

            $this->valueType = 'numeric';

        }else{

            $this->valueType = 'plain';

        }

    }

    public function getValue()
    {
        return $this->value;
    }

    public function getValueType()
    {
        return $this->valueType;
    }

    public function getRaw()
    {
        return $this->raw;
    }
    

    
}
