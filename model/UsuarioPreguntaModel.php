<?php 
    class UsuarioPreguntaModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        public function insertNewUsuarioPregunta($up){
            $this->database->execute("INSERT INTO realiza (pregunta_id,usuario_id) VALUES('".$up->getPreguntaId()."','".$up->getUsuarioId()."')");
        }

        public function deletePreguntasById($id){
            $this->database->execute("DELETE FROM realiza WHERE pregunta_id = '$id'");
        }


    }

?>