<?php 
    class ReportaModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        public function insertNewReporte($reporte){
            $this->database->execute("insert into reporta (usuario_id, pregunta_id, razon) values('".$reporte->getUsuarioId()."','".$reporte->getPreguntaId()."','".$reporte->getRazon()."')");
        }

    }

?>