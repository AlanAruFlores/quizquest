<?php
class LobbyEditorController {
    private $mainSettings;
    private $presenter;
    private $sugiereModel;
    private $respuestaSugeridaModel;
    private $preguntaSugeridaModel;
    private $preguntaModel;
    private $respuestaModel;

    public function __construct($presenter,$sugiereModel, $preguntaSugeridaModel, $respuestaSugeridaModel,$preguntaModel,$respuestaModel,$mainSettings){
        $this->presenter = $presenter;
        $this->sugiereModel = $sugiereModel;
        $this->preguntaSugeridaModel = $preguntaSugeridaModel;
        $this->respuestaSugeridaModel = $respuestaSugeridaModel;
        $this->preguntaModel=$preguntaModel;
        $this->respuestaModel = $respuestaModel;
        $this->mainSettings = $mainSettings;
    }

    public function get(){
        $preguntasSugeridas = $this->sugiereModel->getPreguntasSugeridas();
        $arraySugeridas = $this->sugiereModel->gerArraySugestsByPreguntas($preguntasSugeridas);
        $this->presenter->render("view/viewLobbyEditor.mustache",
            ["sugeridasPreguntas" => $arraySugeridas,
            ...$this->mainSettings]);
    }


    //Agrego una sugerencia
    public function acceptSuggest(){
        $preguntaNueva = $this->preguntaSugeridaModel->getPreguntaSugeridaById($_GET["id"]);
        $respuestasNuevas= $this->sugiereModel->getRespuestasSugeridasByPreguntaSugeridaId($_GET["id"]);

    
        $this->preguntaModel->insertNewPregunta($preguntaNueva);
        $this->respuestaModel->insertAllRespuestas($respuestasNuevas,$this->preguntaModel->getLastPregunta()["id"]);


        $this->sugiereModel->deleteRespuestasSugeridasByPreguntaSugeridaId($_GET["id"]);

        header("Location:/quizquest/lobbyeditor/get");
    }

    //Elimino una sugerencia
    public function deleteSuggest(){
        $this->sugiereModel->deleteRespuestasSugeridasByPreguntaSugeridaId($_GET["id"]);

        header("Location:/quizquest/lobbyeditor/get");
    }

}