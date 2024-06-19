<?php
class LobbyEditorController {
    private $mainSettings;
    private $presenter;
    private $sugiereModel;
    private $respuestaSugeridaModel;
    private $preguntaSugeridaModel;
    private $preguntaModel;
    private $respuestaModel;
    private $reportaModel;

    public function __construct($presenter,$sugiereModel, $preguntaSugeridaModel, $respuestaSugeridaModel,$preguntaModel,$respuestaModel,$reportaModel,$mainSettings){
        $this->presenter = $presenter;
        $this->sugiereModel = $sugiereModel;
        $this->preguntaSugeridaModel = $preguntaSugeridaModel;
        $this->respuestaSugeridaModel = $respuestaSugeridaModel;
        $this->preguntaModel=$preguntaModel;
        $this->respuestaModel = $respuestaModel;
        $this->mainSettings = $mainSettings;
        $this->reportaModel = $reportaModel;
    }

    public function get(){
        
        //Obtengo preguntas sugeridas con sus respuestas
        $preguntasSugeridas = $this->sugiereModel->getPreguntasSugeridas();
        $arraySugeridas = $this->sugiereModel->gerArraySugestsByPreguntas($preguntasSugeridas);

        //Obtengo respuestas reportadas con sus respuestas
        $preguntasReportadas = $this->reportaModel->getPreguntasReportadas();
        $arrayReportadas = $this->reportaModel->getArrayReportsByPreguntas($preguntasReportadas);

        $this->presenter->render("view/viewLobbyEditor.mustache",
            ["sugeridasPreguntas" => $arraySugeridas,
            "reportesPreguntas" => $arrayReportadas,
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


    public function deleteReport(){
        $this->reportaModel->deleteRespuestasReportadasAndPreguntaReportada($_GET["id"],$_GET["idPregunta"]);
        header("Location:/quizquest/lobbyeditor/get");
    }

    public function cancelReport(){
        $this->reportaModel->cancelReport($_GET["id"],$_GET["idPregunta"]);
        header("Location:/quizquest/lobbyeditor/get");
    }

}