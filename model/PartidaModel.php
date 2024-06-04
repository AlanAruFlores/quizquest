<?php 
    include_once("model/Partida.php");
    class PartidaModel{
        private $database;        
        public function __construct($database){
            $this->database = $database;
        }

        public function insertNewPartida($partida){
            return $this->database->execute("INSERT INTO partida (nombre,puntaje) VALUES('".$partida->getNombre()."','".$partida->getPuntaje()."')");
        }

        public function getPartidaByName($partida){
            return $this->database->query("SELECT * FROM partida WHERE nombre = '".$partida->getNombre()."'");
        }

        public function updatePartidaPoints($partida, $points){
            $partida->setPuntaje($partida->getPuntaje()+$points);
            $this->database->execute("UPDATE partida SET puntaje = puntaje+$points WHERE id = '".$partida->getId()."'");  
        }
    }
?>