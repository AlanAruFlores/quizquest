<?php
include_once ("model/Partida.php");
include_once("model/Temporizador.php");

class LobbyUsuarioController
{

    private $mainSettings;
    private $presenter;
    private $partidaModel;
    private $usuarioPartidaPreguntaModel;
    private $preguntaModel;
    public function __construct($presenter, $partidaModel, $mainSettings)
    {
        $this->presenter = $presenter;
        $this->mainSettings = $mainSettings;
        $this->partidaModel = $partidaModel;
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
        
    }


    public function exit()
    {
        unset($_SESSION["usuarioLogged"]);
        header("Location:/quizquest/login/get");
    }

}
?>