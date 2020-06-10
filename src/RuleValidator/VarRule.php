<?php 

namespace PhpCmder\RuleValidator;
use PhpCmder\App;
use PhpCmder\Argument;


class VarRule extends Validator
{


    public function runCheck()
    {
        foreach ($this->rules as $key => $value) {

            $rule[$key] = new \stdClass;

            $rule[$key]->target = $key;

            foreach ($value as $rulekey => $value2) {

                $rule[$key]->rule = $rulekey;

                $rule[$key]->value = $value2;

                $rule[$key]->display = $this->rules[$key]['display'] ??  $key;

                if (method_exists($this, $rulekey)){
                    
                    $this->$rulekey($rule[$key]);
    
                }else{
    
                }

            }

        }
    }





    final public function required(\stdClass $rule)
    {
        
        if ( !self::checkType( ['bool'], $rule->value ) ){

            if ($this->app->hasDumper('_error')){

                $this->app->getDumper('_error')->error("The \"{$rule->rule}\" rule can only have boolean value.");

            }
            
        }

        

        if( $rule->value === true &&  $this->ctrl->varEmpty($rule->target) ){

            $this->app->getDumper('_error')->error(" {$rule->display}  is required.");

        }


    }





    final public function min(\stdClass $rule)
    {
        
        if ( !self::checkType( ['int'], $rule->value ) ){

            if ($this->app->hasDumper('_error')){

                $this->app->getDumper('_error')->error("The \"{$rule->rule}\" rule can only have integer value.");

            }
            
        }

        if ( !($this->ctrl->getVar($rule->target) instanceof  Argument) ) return;

        

        if( strlen( $this->ctrl->getVar($rule->target)->getValue() ) < $rule->value ){

            $this->app->getDumper('_error')->error(" {$rule->display} can not be shorter than {$rule->value} characters.");

        }


    }





    final public function max(\stdClass $rule)
    {
        
        if ( !self::checkType( ['int'], $rule->value ) ){

            if ($this->app->hasDumper('_error')){

                $this->app->getDumper('_error')->error("The \"{$rule->rule}\" rule can only have integer value.");

            }
            
        }

        if ( !($this->ctrl->getVar($rule->target) instanceof  Argument) ) return;

        

        if( strlen( $this->ctrl->getVar($rule->target)->getValue() ) > $rule->value ){

            $this->app->getDumper('_error')->error(" {$rule->display} can not be longer than {$rule->value} characters.");

        }


    }





    final public function matches(\stdClass $rule)
    {
        
        if ( !self::checkType( ['string'], $rule->value ) ){

            if ($this->app->hasDumper('_error')){

                $this->app->getDumper('_error')->error("The \"{$rule->rule}\" rule can only have integer value.");

            }
            
        }

        if ( !($this->ctrl->getVar($rule->target) instanceof  Argument) || !($this->ctrl->getVar($rule->value) instanceof  Argument) ) return;

        

        if( $this->ctrl->getVar($rule->target)->getValue() !== $this->ctrl->getVar($rule->value)->getValue() ){

            $this->app->getDumper('_error')->error(" {$rule->display} must match {$this->rules[$rule->value]['display']}.");

        }


    }


}