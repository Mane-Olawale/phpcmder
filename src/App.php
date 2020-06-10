<?php

namespace PhpCmder;
//use PhpCmder\Interfaces\AppInterface;
use PhpCmder\Chain\ChainNode;
use PhpCmder\Dumper\ErrorDumper;


class App
{
    private $commandRegistry = [];

    private $options = null;

    public $argv = [];

    private $commandName = null;

    private $scriptName = null;

    public static $VALUETYPES = [
        'plain',
        'string',
        'numeric'
    ];

    protected $dumper = [];
    

    public function __construct()
    {

        $this->getArgv();

        $this->resolveScriptName();

        $this->resolveCommandName();

        $this->loadArgvChain();

        $this->addDumper('_error', ErrorDumper::class );

    }



    public function _bailOut()
    {
        exit;
    }



    public function addDumper(string $key, string $class)
    {
        if (!isset($this->dumper[$key])){

            $this->dumper[$key] = new $class($this);

        }
    }



    public function removeDumper(string $key)
    {
        if (isset($this->dumper[$key])){

            unset($this->dumper[$key]);

        }
    }



    public function getDumper(string $key)
    {
        if (isset($this->dumper[$key])){

            return $this->dumper[$key];

        }
    }



    public function hasDumper(string $key)
    {

        if (isset($this->dumper[$key])){

            return true;

        }else{

            return true;

        }


    }



    public function addCommand(string $command, Controller $controller)
    {
        $this->commands[strtolower( $command )] = $controller;
    }


    public function run()
    {
        if(isset($this->commands[strtolower( $this->commandName )])){

            $controller = $this->commands[$this->commandName];
            $controller->_boot($this);
            $controller->init();

            $this->proccessArgvChain($controller);

            $controller->_check();


            $controller->execute();
        } else {
            echo "Error: Command not found";
        }
    }




    private function getArgv()
    {
        
        global $argv;
        if (!is_array($argv)) {
            if (!@is_array($_SERVER['argv'])) {
                if (!@is_array($GLOBALS['HTTP_SERVER_VARS']['argv'])) {
                    throw new Exception(
                        "Could not read cmd args (register_argc_argv=Off?)",
                        Exception::E_ARG_READ
                    );
                }
                $this->argv = $GLOBALS['HTTP_SERVER_VARS']['argv'];
                return;
            }
            $this->argv = $_SERVER['argv'];
            return;
        }


        $this->argv = $argv;
        return;


    }




    private function resolveScriptName()
    {
        if (!is_null($this->scriptName)) {
            throw new Exception(
                "The script name is already set."
            );
        }
        if (is_null($this->argv)) {
            throw new Exception(
                "The server variables are not yet loaded."
            );
        }
        $this->scriptName = array_shift($this->argv);
    }





    private function resolveCommandName()
    {

        if (!is_null($this->commandName)) {
            throw new Exception(
                "The command name is already set."
            );
        }
        if (is_null($this->argv)) {
            throw new Exception(
                "The server variables are not yet loaded."
            );
        }

        $this->commandName = strtolower( $this->argv[0] );

    }




    public function LoadArgvChain()
    {
        $this->linkIndex = [];

        $this->chainRoot = null;

        foreach ($this->argv as $value) {
            $this->linkIndex[] = new ChainNode($value);
        }

        foreach ($this->linkIndex as $key => $value) {

            if ($key !== 0){
                $value->setUpNode( $this->linkIndex[$key - 1] );
            }else{
                $this->chainRoot = $value;
            }

            if ( ( count($this->linkIndex) - 1 ) !== $key ){
                $value->setDownNode( $this->linkIndex[$key + 1] );
            }

        }


    }



    




    public function proccessArgvChain(Controller $ctrl)
    {

        $fromValue = false;

        foreach ($this->linkIndex as $key => $value) {
            
            if ($key !== 0){

                $arg = $this->linkIndex[$key]->getArgument();

                $nextArg = (isset($this->linkIndex[$key + 1])) ? $this->linkIndex[$key + 1]->getArgument() : null;

                $prevArg = (isset($this->linkIndex[$key - 1])) ? $this->linkIndex[$key - 1]->getArgument() : null;

                if (!in_array( $arg->getType(), self::$VALUETYPES )){

                    switch ($arg->getType()) {
                        case 'var':
                            $ctrl->setVar([
                                $arg->getKey() => $arg
                            ]);
                            break;
                        case 'option':
                            $ctrl->setOption(
                                $arg->getKey()
                            );
                            break;
                    }

                    if (!is_null($nextArg) && $arg->getType() === 'var' && in_array($nextArg->getType(), self::$VALUETYPES ) ){

                        $arg->setValue( $nextArg->getKey() );

                    }

                    $fromValue = false;

                }else{

                    if ($fromValue){


                        
                        $ctrl->setStrayValues(
                            $arg->getRaw()
                        );

                        /*if ( $ctrl->getCommandRule('noWarning') ) {

                            $this->getDumper('_error')->error("This Value \"{$arg->getRaw()}\" is not associated with and key in your command.");

                        }else{

                            $this->getDumper('_error')->warning("This Value \"{$arg->getRaw()}\" is not associated with and key in your command.");

                        }*/

                    }
                    
                    
                    unset($arg);
                    unset($value);
                    $fromValue = true;
                } 
                


            }else{

                $arg = $this->linkIndex[$key]->getArgument();

                if ( isset( $this->linkIndex[$key + 1] ) ) {

                    $nextArg = $this->linkIndex[$key + 1]->getArgument();

                    if (in_array($nextArg->getType(), self::$VALUETYPES ) ){

                        $arg->setValue( $nextArg->getKey() );

                    }
                }
                $ctrl->setCommand($arg);
                
                $fromValue = false;

            }

        }


    }







}
