<?php
    class Temporizador{
        public $segundos;
        public function __construct($segundos = 10){
            $this->segundos = $segundos;
        }  
        
        public function getSegundos(){
            return $this->segundos;
        }

        public function setSegundos($segundos){
            $this->segundos = $segundos;
        }
    }
?>