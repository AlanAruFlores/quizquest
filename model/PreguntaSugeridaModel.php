<?php 
    include_once("model/PreguntaSugerida.php");
    class PreguntaSugeridaModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        //Insertar una nueva pregunta sugerida
        public function insertNewPreguntaSugerida($preguntaSugerida){
            $this->database->execute("INSERT INTO preguntasugerida (id,descripcion,categoria_id) VALUES ('".$preguntaSugerida->getId()."', '".$preguntaSugerida->getDescripcion()."', '".$preguntaSugerida->getCategoriaId()."')");
        }

    }

?>