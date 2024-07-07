<?php 
    class ReportaModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        /*INSERTAR UN NUEVO REPORTA */
        public function insertNewReporte($reporte){
            $this->database->execute("insert into reporta (id,usuario_id, pregunta_id, razon) values('null','".$reporte->getUsuarioId()."','".$reporte->getPreguntaId()."','".$reporte->getRazon()."')");
        }

        public function getPreguntasReportadas(){
            return $this->database->query("select r.id as reportada_id, p.id as pregunta_reportada_id, p.descripcion, r.razon, u.nombrerUsuario from reporta r 
                    join pregunta p on r.pregunta_id = p.id
                    join usuario u on r.usuario_id = u.id;");
        }


        /*Obtener las respuestas reportadas por el id del reporte */
        public function getRespuestasReportadasByReportadaId($id){
            $respuestasAux =  $this->database->query("select rs.id, rs.descripción as descripcion, rs.esCorreto as esCorrecto from reporta r 
                join pregunta p on r.pregunta_id = p.id
                join respuesta rs on rs.pregunta_id = r.pregunta_id
                where r.id = $id;");
    
            $respuestas = [];
            foreach($respuestasAux as $respuesta){
                $respuesta["esCorrecto"] = $respuesta["esCorrecto"] == 1 ? true : false;
                $respuestas[]  = $respuesta;
            }

            return $respuestas;
        }
        public function getArrayReportsByPreguntas($preguntasReportadas){
            $arrayReportadas = array();
            //Si tiene varias filas
            if(self::isBidimentionalResult($preguntasReportadas)){
                foreach ($preguntasReportadas as $pregunta) {
                    $respuestas = self::getRespuestasReportadasByReportadaId($pregunta["reportada_id"]);
                        array_push($arrayReportadas, [
                        "preguntaReportada"=>$pregunta,
                        "respuestasReportadas"=>$respuestas
                    ]);
                }
            }
            //Si solo tiene una fila como resultado
            else if (count($preguntasReportadas) > 0){
                $respuestas = self::getRespuestasReportadasByReportadaId($preguntasReportadas["reportada_id"]);
                array_push($arrayReportadas, [
                    "preguntaReportada"=>$preguntasReportadas,
                    "respuestasReportadas"=>$respuestas
                ]);  
             }
    
             return $arrayReportadas;
        }
    
        public function isBidimentionalResult($result__array){
            if(!is_array($result__array))
                return false;
        
            foreach ($result__array as $element) {
                if(is_array($element))
                    return true;
            }
    
            return false;
        }


        public function deleteRespuestasReportadasAndPreguntaReportada($id, $idPregunta){
            $respuestasReportadas = self::getRespuestasReportadasByReportadaId($id);
            //Me aseguro que se elimine todos los reportes relacionados a la pregunta.
            $this->database->execute("DELETE FROM reporta WHERE pregunta_id='$idPregunta'");
            $this->database->execute("DELETE FROM realiza WHERE pregunta_id='$idPregunta'");
            foreach($respuestasReportadas as $respuesta)
                $this->database->execute("DELETE FROM respuesta WHERE id = '".$respuesta["id"]."'");
            $this->database->execute("DELETE FROM pregunta WHERE id = '$idPregunta'");
        }

        public function cancelReport($id, $idPregunta){
            $this->database->execute("DELETE FROM reporta WHERE id='$id'");
            $this->database->execute("UPDATE pregunta SET esValido = true WHERE id=$idPregunta");
        }

        public function deletePreguntasById($id){
            $this->database->execute("DELETE FROM reporta WHERE pregunta_id = '$id'");
        }
    }

?>