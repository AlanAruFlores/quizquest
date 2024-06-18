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

        //Obtener siempre el ultimo id de la ultima pregunta 
        public function getLastPreguntaSugeridaId(){
            $preguntaSugeridaId = $this->database->query("select id from preguntasugerida order by id desc limit 1");
            if($preguntaSugeridaId == null)
                return 1;
        
            return ++$preguntaSugeridaId["id"];
        }

        public function getPreguntaSugeridaById($id){
            return $this->database->query("SELECT * FROM preguntasugerida WHERE id = '$id'");           
        }

    }

?>