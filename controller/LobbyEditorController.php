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
        $arraySugeridas = $this->sugiereModel->gerArraySugestsByPreguntas($preguntasSugeridas);
        $this->presenter->render("view/viewLobbyEditor.mustache",
            ["sugeridasPreguntas" => $arraySugeridas,
            ...$this->mainSettings]);
    }


    //Agrego una sugerencia
    public function acceptSuggest(){
        $idPreguntaSugerida = $_GET["id"];

    }

    //Elimino una sugerencia
    public function deleteSuggest(){
        $this->sugiereModel->deletePreguntaSugeridaById($_GET["id"]);
        header("Location:/quizquest/lobbyeditor/get");
    }

}