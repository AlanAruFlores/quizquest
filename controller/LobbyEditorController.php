<?php
class LobbyEditorController {
    private $mainSettings;
    private $presenter;
    private $sugiereModel;
    private $respuestaSugeridaModel;

    public function __construct($presenter,$sugiereModel, $respuestaSugeridaModel, $mainSettings){
        $this->presenter = $presenter;
        $this->sugiereModel = $sugiereModel;
        $this->respuestaSugeridaModel = $respuestaSugeridaModel;
        $this->mainSettings = $mainSettings;
    }

    public function get(){
        $preguntasSugeridas = $this->sugiereModel->getPreguntasSugeridas();
        //var_dump($preguntasSugeridas);
        //echo "-----------------";

        $arraySugeridas = array();
        foreach ($preguntasSugeridas as $pregunta) {
            $respuestas = $this->sugiereModel->getRespuestasSugeridasByPreguntaSugeridaId($pregunta["pregunta_sugerida_id"]);
             array_push($arraySugeridas, [
                "preguntaSugerida"=>$pregunta,
                "respuestasSugeridas"=>$respuestas
            ]);
        }

        //var_dump($arraySugeridas);

        //die();
        $this->presenter->render("view/viewLobbyEditor.mustache",
            ["sugeridasPreguntas" => $arraySugeridas,
            ...$this->mainSettings]);
    }

}