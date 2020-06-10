<?php 

namespace PhpCmder\RuleValidator;

use PhpCmder\Controller;

use PhpCmder\App;

abstract class Validator 
{
    protected $rules = [];

    protected $data = [];

    protected $app = null;

    protected $ctrl = null;


    public function __construct(array $rules, $data,Controller $ctrl, App $app)
    {
        $this->rules = $rules;

        $this->data = $data;

        $this->ctrl = $ctrl;

        $this->app = $app;

    }


    public function runCheck()
    {
        foreach ($this->rules as $key => $value) {
            if (method_exists($this, $key)){
                
                $this->$key([ $key, $value ]);

            }else{

            }
        }
    }


    public static function checkType(array $types, $value)
    {

        foreach ($types as $type) {

            switch ($type) {

                case 'string':
                    if (is_string( $value )) return true;
                    break;
                case 'int':
                    if (is_int( $value )) return true;
                    break;
                case 'array':
                    if (is_array( $value )) return true;
                    break;
                case 'bool':
                    if ( is_bool( $value ) ) return true;
                    break;
                
                default:
                    return false;
                    break;

            }

        }

    }
}