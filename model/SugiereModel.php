<?php 
    include_once("model/Sugiere.php");

    class SugiereModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        public function insertNewSugiere($sugiere){
            $this->database->execute("INSERT INTO sugiere(usuario_id,preguntasugerida_id,respuestasugerida_id) VALUES('".$sugiere->getUsuarioId()."','".$sugiere.getPreguntaSugeridaId()."','".$sugiere->getRespuestaSugeridaId()."')");
        }



    }

?>