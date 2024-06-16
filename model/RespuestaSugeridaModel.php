<?php
    include_once("model/RespuestaSugerida.php");

    class RespuestaSugeridaModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }


        //Insertar nueva Pregunta sugerida
        public function insertNewRespuestaSugerida($respuestaSugerida){
            $this->database->execute("INSERT INTO respuestasugerida (id,descripcion,esCorrecta) VALUES ('".$respuestaSugerida->getId()."','".$respuestaSugerida->getDescripcion()."','".$respuestaSugerida->getEsCorrecto()."')");
        }

    }

?>