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
        return $this->database->query('select distinct u.id as "usuario_id" , u.nombrerUsuario, ps.id as "pregunta_sugerida_id", ps.descripcion as "pregunta_descripcion" from sugiere s join usuario u on s.usuario_id = u.id join preguntasugerida ps on s.preguntasugerida_id = ps.id;');

    }

    public function getRespuestasSugeridasByPreguntaSugeridaId($id){
        return $this->database->query("select rs.id, rs.descripcion,rs.esCorrecto from sugiere s 
            join respuestasugerida rs on s.respuestasugerida_id = rs.id
            join preguntasugerida ps on s.preguntasugerida_id = ps.id
            where s.preguntasugerida_id = '$id';");
    }
}

?>