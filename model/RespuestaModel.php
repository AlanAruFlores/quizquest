<?php 
    include_once("model/Respuesta.php");
    class RespuestaModel{
        private $database;        
        public function __construct($database){
            $this->database = $database;
        }

        public function getRespuestaByPreguntaId($preguntaId){
            return $this->database->query("select r.id as res_id, r.esCorreto, r.descripción as descripcion_respuesta,r.letra, p.id as preg_id, p.descripcion as descripcion_pregunta, p.punto, p.esValido from respuesta r join pregunta p on r.pregunta_id = p.id where p.id = $preguntaId;");
        }

        public function getRespuestaByRespuestaIdAndPreguntaId($respuestaId, $preguntaId){
            return $this->database->query("select * from respuesta where id='$respuestaId' and pregunta_id='$preguntaId'");
        }

        //Metodo para crear un nuevo Usuario

    }
?>