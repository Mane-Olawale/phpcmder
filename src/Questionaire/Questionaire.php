<?php

namespace PhpCmder\Questionaire;

use PhpCmder\Controller;

class Questionaire
{
    private $ctrl;

    private array $questions = [

    ];

    private array $answers = [

    ];
    
    public function __construct( Controller $ctrl )
    {
        $this->ctrl = $ctrl;
    }


    public function ask(array $questions = [])
    {
        if (empty($questions)) return;

        $this->questions[] = $questions;
    }


    public function start()
    {
        foreach ($this->questions as $key => $value) {

            $this->answers[ $value['key'] ] = '';

            $force = $value['force'] ?? false;

            $this->answers[ $value['key'] ] = readline("\n" . $value['ask'] . ": ");

            do {

                if ( $value['force'] === false || !empty( $this->answers[ $value['key'] ] ) ) break;

                $this->answers[ $value['key'] ] = readline("" . $value['ask'] . ":");

            } while ( empty( $this->answers[ $value['key'] ] ) );

            //$validate

            //readline_add_history($value['answer']);

        }
    }


 


}