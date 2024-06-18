<?php
include_once("model/Partida.php");
include_once("model/Temporizador.php");
include_once("model/PreguntaSugerida.php");
include_once("model/RespuestaSugerida.php");
include_once("model/Sugiere.php");

class LobbyUsuarioController
{

    private $mainSettings;
    private $presenter;
    private $partidaModel;
    private $preguntaSugeridaModel;
    private $respuestaSugeridaModel;
    private $sugiereModel;
    public function __construct($presenter, $partidaModel,$preguntaSugeridaModel, $respuestaSugeridaModel, $sugiereModel, $mainSettings)
    {
        $this->presenter = $presenter;
        $this->mainSettings = $mainSettings;
        $this->partidaModel = $partidaModel;
        $this->preguntaSugeridaModel = $preguntaSugeridaModel;
        $this->respuestaSugeridaModel = $respuestaSugeridaModel;
        $this->sugiereModel = $sugiereModel;
    }

    public function get()
    {
        //Mando al lobby el usuario actual logeado
        $this->presenter->render("view/viewLobbyUsuario.mustache", [
            "usuarioLogeado" => $_SESSION["usuarioLogged"],
            ...$this->mainSettings
        ]);
    }

    public function createNewPartida()
    {
        //INSERTO Y OBTENGO LA PARTIDA
        $partida = new Partida();
        $partida->setNombre($_POST["nombre"]);
        $partida->setPuntaje(0);
        $partida->setUsuarioId($_SESSION["usuarioLogged"]["id"]);

        $this->partidaModel->insertNewPartida($partida);
        $partidaObject = $this->partidaModel->getPartidaByName($partida);
        $_SESSION["partidaActual"] = $partidaObject;

        $_SESSION["indicePregunta"] = 0;

        //Aseguro que el usuario luego no se pueda ir libremente
        $_SESSION["isPlaying"] = true;
        header("Location:/quizquest/juego/get");
    }


    public function suggestNewQuestion(){

        //Obtengo los ultimos IDS de preguntas y respuestas del bd:
        $lastIdPreguntaSugerida= $this->preguntaSugeridaModel->getLastPreguntaSugeridaId();
        $lastIdRespuestaSugerida = $this->respuestaSugeridaModel->getLastRespuestaSugeridaId();

        //Instancio las preguntas y respuestas nuevas y a sugerir
        $this->preguntaSugeridaModel->insertNewPreguntaSugerida(new PreguntaSugerida($lastIdPreguntaSugerida,$_POST["descripcionPregunta"],$_POST["preguntaCategoriaId"]));

        for($i = 1; $i<=intval($_POST["cantidadPreguntas"]); $i++){
            $this->respuestaSugeridaModel->insertNewRespuestaSugerida(new RespuestaSugerida($lastIdRespuestaSugerida,$_POST["respuesta$i"], ($i== $_POST["esCorrecta"]) ? TRUE : FALSE));
            $sugerir = new Sugiere($_SESSION["usuarioLogged"]["id"], $lastIdPreguntaSugerida,$lastIdRespuestaSugerida++);
            $this->sugiereModel->insertNewSugiere($sugerir);
        }
        
        header("Location:/quizquest/lobbyusuario/get");
    }


    public function exit()
    {
        unset($_SESSION["usuarioLogged"]);
        header("Location:/quizquest/login/get");
    }

}
?>