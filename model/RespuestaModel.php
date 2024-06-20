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

        public function insertAllRespuestas($respuestasArray,$preguntaId){
            $letras = ['A','B','C','D'];
            $i = 0 ;
            foreach($respuestasArray as $respuestaNueva){

                $this->database->execute("insert into respuesta (id,esCorreto,descripción,letra,pregunta_id) values ('null','".$respuestaNueva["esCorrecto"]."','".$respuestaNueva["descripcion"]."','".$letras[$i++]."','$preguntaId')");
            }
        }

        public function updateRespuesta($respuesta){
            $this->database->execute("update respuesta SET descripción = '".$respuesta["descripcion_respuesta"]."', esCorreto = '".$respuesta["esCorreto"]."' where id = '".$respuesta["res_id"]."'");
        }

        public function deleteRespuestasByPreguntaId($id){
            $this->database->execute("delete from respuesta where pregunta_id = '$id'");
        }
    }
?>