<?php 

namespace PhpCmder\RuleValidator;
use PhpCmder\App;


class CommandRule extends Validator
{



    final public function hasValue(array $rule)
    {
        
        if ( !self::checkType( ['bool'], $rule[1] ) ){

            if ($this->app->hasDumper('_error')){

                $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule can only have boolean a value.");

            }
            
        }

        

        if( $rule[1] === true && empty($this->_getData()->getValue())){

            $this->app->getDumper('_error')->error("This command must have a value.");

        }


    }




    final public function type( array $rule )
    {

        $value = $rule[1];
        
        if ( !self::checkType( [ 'string' , 'array' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a String or Array value.");

        }

        
        if ( $value === 'numeric' ) echo $this->_getData()->getValueType();
        
        if( $value === 'any' ){

        } else if ( is_array($value) && !in_array($this->_getData()->getValueType(), $value)){

            $this->app->getDumper('_error')->error("Invalid command type, type {$value['0']} or {$value['1']} expected.");

        }else if( $value !== $this->_getData()->getValueType() && in_array($value, App::$VALUETYPES) ){

            $this->app->getDumper('_error')->error("Invalid command value type, type \"{$value}\" expected.");

        } else if ( $value === 'text' && !in_array($this->_getData()->getValueType(), ['plain', 'string'])){

            $this->app->getDumper('_error')->error("Invalid command type, type \"plain\" or \"string\" expected.");
        }


    }




    final public function noStrayValues( array $rule )
    {

        $value = $rule[1];
        $rule = $rule[0];
        
        if ( !self::checkType( [ 'bool' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a boolean value.");

        }
        
        if ( $this->ctrl->getStrayValues() ){

            $msg = count($this->ctrl->getStrayValues()) . "  Value(s) is/are not associated with and key in your input.";

            if ( $this->ctrl->getCommandRule('noWarning') === true ) {

                $this->app->getDumper('_error')->error( $msg );

            }else{

                $this->app->getDumper('_error')->warning( $msg );

            }

        }


    }




    final public function noWarning( array $rule )
    {

        $value = $rule[1];
        $rule = $rule[0];
        
        if ( !self::checkType( [ 'bool' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a boolean value.");

        }


    }




    final public function hasVar( array $rule )
    {

        $value = $rule[1];
        $rule = $rule[0];
        
        if ( !self::checkType( [ 'bool' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a boolean value.");

        }

        if ( !$value && $this->ctrl->getVar() ){

            $this->app->getDumper('_error')->error("The \"{$this->ctrl->getCommandName()}\" command can not have additional variable(s).");

        }




    }




    final public function minVar( array $rule )
    {

        $value = $rule[1];
        $rule = $rule[0];
        
        if ( !self::checkType( [ 'int' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a boolean value.");

        }
        
        if ( is_int($this->ctrl->getCommandRule('maxVar')) && $this->ctrl->getCommandRule('maxVar') < $value ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule can not be greater than the \"maxVar\" rule.");

        }

        if ( $value > count($this->ctrl->getVar()) ){

            $this->app->getDumper('_error')->error("The \"{$this->ctrl->getCommandName()}\" command can not have less than {$value} variable(s).");

        }




    }




    final public function maxVar( array $rule )
    {

        $value = $rule[1];
        $rule = $rule[0];
        
        if ( !self::checkType( [ 'int' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a boolean value.");

        }
        
        if ( is_int($this->ctrl->getCommandRule('minVar')) && $this->ctrl->getCommandRule('minVar') > $value ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule can not be less than the \"minVar\" rule.");

        }

        if ( $value < count($this->ctrl->getVar()) ){

            $this->app->getDumper('_error')->error("The \"{$this->ctrl->getCommandName()}\" command can not have greater than {$value} variable(s).");

        }




    }




    final public function hasOption( array $rule )
    {

        $value = $rule[1];
        $rule = $rule[0];
        
        if ( !self::checkType( [ 'bool' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a boolean value.");

        }

        if ( !$value && $this->ctrl->getOption() ){

            $this->app->getDumper('_error')->error("The \"{$this->ctrl->getCommandName()}\" command can not have option(s).");

        }




    }




    final public function minOption( array $rule )
    {

        $value = $rule[1];
        $rule = $rule[0];
        
        if ( !self::checkType( [ 'int' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a boolean value.");

        }
        
        if ( is_int($this->ctrl->getCommandRule('maxOption')) && $this->ctrl->getCommandRule('maxOption') < $value ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule can not be greater than the \"maxOption\" rule.");

        }

        if ( $value > count($this->ctrl->getOption()) ){

            $this->app->getDumper('_error')->error("The \"{$this->ctrl->getCommandName()}\" command can not have less than {$value} Option(s).");

        }




    }




    final public function maxOption( array $rule )
    {

        $value = $rule[1];
        $rule = $rule[0];
        
        if ( !self::checkType( [ 'int' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a boolean value.");

        }
        
        if ( is_int($this->ctrl->getCommandRule('minOption')) && (int)$this->ctrl->getCommandRule('minOption') > $value ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule can not be less than the \"minOption\" rule.");

        }

        if ( $value < count($this->ctrl->getOption()) ){

            $this->app->getDumper('_error')->error("The \"{$this->ctrl->getCommandName()}\" command can not have greater than {$value} Option(s).");

        }




    }




    final public function allowedVar( array $rule )
    {

        $value = $rule[1];
        $rule = $rule[0];
        
        if ( !self::checkType( [ 'array' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a boolean value.");

        }

        $error = false;

        foreach ($this->ctrl->getVar() as $key => $value) {

            if ( !in_array($key, $value) ){

                $this->app->getDumper('_error')->warning("The \"{$key}\" variable is not allowed.");

                $error = true;
    
            }

        }
        

        if ( $error ) $this->app->getDumper('_error')->error("Your command has invalid variable(s).");
        

    }




    final public function allowedOption( array $rule )
    {

        $value = $rule[1];
        $rule = $rule[0];
        
        if ( !self::checkType( [ 'array' ], $value ) ){

            $this->app->getDumper('_error')->error("The \"{$rule[0]}\" rule must be a boolean value.");

        }

        $error = false;

        foreach ($this->ctrl->getOption() as $value2) {

            if ( !in_array($value2, $value) ){

                $this->app->getDumper('_error')->warning("The \"{$value2}\" option is not allowed.");

                $error = true;
    
            }

        }
        

        if ( $error ) $this->app->getDumper('_error')->error("Your command has invalid option(s).");
        

    }



    protected function _getData()
    {
        return $this->data;
    }



}