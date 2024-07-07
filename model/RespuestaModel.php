<?php 
    include_once("model/Respuesta.php");
    class RespuestaModel{
        private $database;        
        public function __construct($database){
            $this->database = $database;
        }

        //INSERTAR NUEVA RESPUESTA - LA USA EL EDITOR
        public function insertNewRespuesta($respuesta){
            $this->database->execute("INSERT INTO respuesta (id, esCorreto, descripción, letra, pregunta_id) VALUES ('".$respuesta->getId()."', '".$respuesta->getEsCorrecto()."', '".$respuesta->getDescripcion()."', '".$respuesta->getId()."','".$respuesta->getPreguntaId()."')");
        }

        public function verifyIfExists($idRespuesta, $idPregunta){
            return $this->database->query("select * from respuesta where id = '$idRespuesta' and pregunta_id = '$idPregunta'");
        }

        //QUERY QUE DEVUELVE REGISTROS DE LAS RESPUESTAS DE UNA PREGUNTA
        public function getRespuestaByPreguntaId($preguntaId){
            return $this->database->query("select r.id as res_id, r.esCorreto, r.descripción as descripcion_respuesta,r.letra, p.id as preg_id, p.descripcion as descripcion_pregunta, p.punto, p.esValido from respuesta r join pregunta p on r.pregunta_id = p.id where p.id = $preguntaId;");
        }

            //QUERY QUE DEVUELVE UNA RESPUESTA POR SU ID Y EL ID DE LA PREGUNTA

        public function getRespuestaByRespuestaIdAndPreguntaId($respuestaId, $preguntaId){
            return $this->database->query("select * from respuesta where id='$respuestaId' and pregunta_id='$preguntaId'");
        }

        //CREAR RESPUESTAS DE UNA PREGUNTA NUEVA Y LA USA EL EDITOR
        public function createAllRespuestas($respuestasArray){
            $letras = ['A','B','C','D'];
            $i = 0 ;
            foreach($respuestasArray as $respuestaNueva){

                $this->database->execute("insert into respuesta (id,esCorreto,descripción,letra,pregunta_id) values ('null','".$respuestaNueva->getEsCorrecto()."','".$respuestaNueva->getDescripcion()."','".$letras[$i++]."','".$respuestaNueva->getPreguntaId()."')");
            }
        }

        public function insertAllRespuestas($respuestasArray,$preguntaId){
            $letras = ['A','B','C','D'];
            $i = 0 ;
            foreach($respuestasArray as $respuestaNueva){

                $this->database->execute("insert into respuesta (id,esCorreto,descripción,letra,pregunta_id) values ('null','".$respuestaNueva["esCorrecto"]."','".$respuestaNueva["descripcion"]."','".$letras[$i++]."','$preguntaId')");
            }
        }

        //ACTUALIZAR RESPUESTA
        public function updateRespuesta($respuesta){
            $this->database->execute("update respuesta SET descripción = '".$respuesta["descripcion_respuesta"]."', esCorreto = '".$respuesta["esCorreto"]."' where id = '".$respuesta["res_id"]."'");
        }

        //ELIMINAR TODAS LAS RESPUESTAS DE UNA PREGUNTA
        public function deleteRespuestasByPreguntaId($id){
            $this->database->execute("delete from respuesta where pregunta_id = '$id'");
        }

        //OBTENER RESPUESTA CORRECTA , USA EL BOT Y EL HELADO
        public function getRespuestaCorrectaByPreguntaId($idPregunta){
            return $this->database->query("select r.* from respuesta r 
            join pregunta p on r.pregunta_id = p.id 
            where r.esCorreto = '1' and p.id = '$idPregunta'"); 
        }
    }
?>