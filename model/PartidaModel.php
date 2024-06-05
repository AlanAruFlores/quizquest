<?php 
    include_once("model/Partida.php");
    class PartidaModel{
        private $database;        
        public function __construct($database){
            $this->database = $database;
        }

        public function insertNewPartida($partida){
            return $this->database->execute("INSERT INTO partida (nombre,puntaje,usuario_id) VALUES('".$partida->getNombre()."','".$partida->getPuntaje()."', '".$partida->getUsuarioId()."')");
        }

        public function getPartidaByName($partida){
            return $this->database->query("SELECT * FROM partida WHERE nombre = '".$partida->getNombre()."'");
        }

        public function update($partida){
            $this->database->execute("UPDATE partida SET nombre='".$partida["nombre"]."', puntaje = puntaje+".$partida["puntaje"]." WHERE id = '".$partida["id"]."'");  
        }

        public function increasePartidaPoints($partida, $points){
            $partida["puntaje"]+=$points;
            self::update($partida);
            return $partida;
        }
    }
?>