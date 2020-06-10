<?php

namespace PhpCmder;

use PhpCmder\App;
use PhpCmder\RuleValidator\CommandRule;
use PhpCmder\RuleValidator\VarRule;

abstract class Controller
{
    protected $commandName;

    protected $commandRule = [];

    protected $varRule = [];

    protected $optionRule = [];

    protected $command = [];

    protected $var = [];

    protected $strayValues = [];

    protected $option = [];


    protected $app = null;


    public function _boot(App $app)
    {
        $this->app = $app;
    }


    protected function commandRule(array $var = [])
    {
        $this->commandRule = $var;
    }


    protected function varRule(array $var = [])
    {
        $this->varRule = $var;
    }


    protected function optionRule(array $var = [])
    {
        $this->optionRule = $var;
    }


    public function getCommandRule(string $var = '')
    {
        if (substr($var, 0, 1) === ':'){
            return (isset($this->commandRule[$var])) ? $this->commandRule[$var] : null;
        }

        return (isset($this->commandRule[$var])) ? $this->commandRule[$var] : $this->commandRule;
    }


    public function commandRuleExists(string $var = '')
    {
        return (isset($this->commandRule[$var])) ? true : false;
    }


    public function getVarRule( string $var = '' )
    {
        return (isset($this->varRule[$var])) ? $this->varRule[$var] : null;
    }


    public function getAllVarRule()
    {
        return $this->varRule;
    }


    public function getOptionRule()
    {
        return $this->optionRule;
    }


    public function getVar(string $var = '')
    {
        return (isset($this->var[$var])) ? $this->var[$var] : $this->var;
    }


    public function varExists(string $var = '')
    {
        return (isset($this->var[$var])) ? true : false;
    }


    public function varEmpty(string $var = '')
    {
        return (!isset( $this->var[$var] ) || empty( $this->var[$var]->getValue() )) ? true : false;
    }


    public function hasOption(string $var = '')
    {
        return in_array($var, $this->option);
    }


    public function getOption()
    {
        return $this->option;
    }


    public function getCommandName()
    {
        return $this->commandName;
    }


    public function getStrayValues()
    {
        return $this->strayValues;
    }


    public function setCommand( $var )
    {
        $this->command = $var;
    }


    public function setVar(array $var = [])
    {
        $this->var += $var;
    }


    public function setStrayValues(string $var)
    {
        $this->strayValues[] = $var;
    }


    public function setOption(string $var)
    {
        $this->option[] = $var;
    }


    public function _check()
    {
        $this->_checkCommand();
    }


    public function _bailOut()
    {
        exit;
    }


    public function _checkCommand()
    {
        

        ($commandRule = new CommandRule($this->getCommandRule(), $this->command, $this, $this->app))->runCheck();

        unset($commandRule);

        ( $varRule = new VarRule($this->getAllVarRule(), $this->getVar(), $this, $this->app) )->runCheck();

        unset($varRule);


    }


    abstract public function init();


    abstract public function execute();



}
