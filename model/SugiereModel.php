<?php
include_once ("model/Sugiere.php");

class SugiereModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    //Inserto una nueva sugerencia
    public function insertNewSugiere($sugiere)
    {
        $this->database->execute("INSERT INTO sugiere(usuario_id,preguntasugerida_id,respuestasugerida_id) VALUES('" . $sugiere->getUsuarioId() . "','" . $sugiere->getPreguntaSugeridaId() . "','" . $sugiere->getRespuestaSugeridaId() . "')");
    }

    //Obtengo las respuestas sugeridas
    public function getPreguntasSugeridas()
    {
        return $this->database->query('select distinct u.id as "usuario_id" , u.nombrerUsuario, ps.id as "pregunta_sugerida_id", ps.descripcion as "pregunta_descripcion", c.nombre as "categoria" from sugiere s 
        join usuario u on s.usuario_id = u.id
        join preguntasugerida ps on s.preguntasugerida_id = ps.id
        join categoria c on ps.categoria_id = c.id;
        ');

    }

    public function getRespuestasSugeridasByPreguntaSugeridaId($id)
    {
        $respuestasAux =  $this->database->query("select rs.id, rs.descripcion,rs.esCorrecto from sugiere s 
            join respuestasugerida rs on s.respuestasugerida_id = rs.id
            join preguntasugerida ps on s.preguntasugerida_id = ps.id
            where s.preguntasugerida_id = '$id';");
    
        $respuestas = [];
        foreach($respuestasAux as $respuesta){
            $respuesta["esCorrecto"] = $respuesta["esCorrecto"] == 1 ? true : false;
            $respuestas[]  = $respuesta;
        }

        return $respuestas;
    }

    public function deleteRespuestasSugeridasByPreguntaSugeridaId($id){
        $respuestasSugeridas = self::getRespuestasSugeridasByPreguntaSugeridaId($id);
        $this->database->execute("DELETE FROM sugiere WHERE preguntasugerida_id='$id'");
        foreach($respuestasSugeridas as $respuesta)
            $this->database->execute("DELETE FROM respuestasugerida WHERE id = '".$respuesta["id"]."'");
        $this->database->execute("DELETE FROM preguntasugerida WHERE id = '$id'");
    }

    //Obtengo un arreglo de sugeridas mediante las preguntas.
    public function gerArraySugestsByPreguntas($preguntasSugeridas){
        $arraySugeridas = array();
        //Si tiene varias filas
        if(self::isBidimentionalResult($preguntasSugeridas)){
            foreach ($preguntasSugeridas as $pregunta) {
                $respuestas = self::getRespuestasSugeridasByPreguntaSugeridaId($pregunta["pregunta_sugerida_id"]);
                    array_push($arraySugeridas, [
                    "preguntaSugerida"=>$pregunta,
                    "respuestasSugeridas"=>$respuestas
                ]);
            }
        }
        //Si solo tiene una fila como resultado
        else if (count($preguntasSugeridas) > 0){
            $respuestas = self::getRespuestasSugeridasByPreguntaSugeridaId($preguntasSugeridas["pregunta_sugerida_id"]);
            array_push($arraySugeridas, [
                "preguntaSugerida"=>$preguntasSugeridas,
                "respuestasSugeridas"=>$respuestas
            ]);  
         }

         return $arraySugeridas;
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
}

?>