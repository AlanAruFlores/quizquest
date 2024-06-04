<?php 
    class UsuarioPartidaPreguntaModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        public function insertNewUsuarioPartidaPregunta($upp){
            $this->database->execute("INSERT INTO realiza (partida_id,pregunta_id,usuario_id) VALUES('".$upp->getPartidaId()."','".$upp->getPreguntaId()."','".$upp->getUsuarioId()."')");
        }

    }

?>