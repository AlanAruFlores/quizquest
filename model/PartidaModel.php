<?php 
    include_once("model/Partida.php");
    class PartidaModel{
        private $database;        
        public function __construct($database){
            $this->database = $database;
        }

        public function getAll() {
            return $this->database->query("SELECT * FROM partida");
        }

        public function insertNewPartida($partida){
            return $this->database->execute("INSERT INTO partida (nombre,puntaje,usuario_id,codigo,fechaCreacion) VALUES('".$partida->getNombre()."','".$partida->getPuntaje()."', '".$partida->getUsuarioId()."', '".$partida->getCodigo()."', CURDATE())");
        }

        public function getPartidaByNameAndCode($partida){
            return $this->database->query("SELECT * FROM partida WHERE nombre = '".$partida->getNombre()."' and codigo = '".$partida->getCodigo()."'");
        }

        public function update($partida){
            $this->database->execute("UPDATE partida SET nombre='".$partida["nombre"]."', puntaje = ".$partida["puntaje"]." WHERE id = '".$partida["id"]."'");  
        }

        public function increasePartidaPoints($partida, $points){
            $partida["puntaje"]+=$points;
            self::update($partida);
            return $partida;
        }

        public function getPartidasRecientes($id){
            return $this->database->query("select * from partida where usuario_id = '$id' order by id desc limit 3");
        }
        public function obtenerPartidasJugador(){
            return $this->database->query("select * from partida p where usuario_id =" . $_SESSION["usuarioLogged"]["id"]);
        }
        
        /*Genero un codigo aleatorio para una partida (no deben repetirse) */
        public function generateCodeRandom(){
            $codigoRandom = "";
            $resultado = "";
            do{
                $codigoRandom  = rand(1,10000);
                $resultado  = $this->database->query("select * from partida where codigo = '$codigoRandom'");
            }while($resultado != null);

            return $codigoRandom;
        }
    }
?>