<?php
include_once ("model/RespuestaSugerida.php");

class RespuestaSugeridaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    //Insertar nueva Pregunta sugerida
    public function insertNewRespuestaSugerida($respuestaSugerida)
    {
        $this->database->execute("INSERT INTO respuestasugerida (id,descripcion,esCorrecto) VALUES ('" . $respuestaSugerida->getId() . "','" . $respuestaSugerida->getDescripcion() . "','" . $respuestaSugerida->getEsCorrecto() . "')");
    }

    //Obtener siempre el ultimo id de la ultima pregunta 
    public function getLastRespuestaSugeridaId()
    {
        $respuestaSugeridaId = $this->database->query("select id from respuestasugerida order by id desc limit 1");

        if ($respuestaSugeridaId == null)
            return 1;

        return ++$respuestaSugeridaId["id"];
    }
}

?>