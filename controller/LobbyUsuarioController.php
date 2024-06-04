
<?php 
    include_once("model/Partida.php");
    class LobbyUsuarioController{

        private $mainSettings;
        private $presenter;
        private $partidaModel;

        public function __construct($presenter,$partidaModel,$mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
            $this->partidaModel = $partidaModel;
        }

        public function get(){
            $this->presenter->render("view/viewLobbyUsuario.mustache",[...$this->mainSettings]);
        }

        public function createNewPartida(){
            $partida = new Partida();
            $partida->setNombre($_POST["nombre"]);
            $partida->setPuntaje(0);
            $this->partidaModel->insertNewPartida($partida);
            $_SESSION["partidaActual"] = $this->partidaModel->getPartidaByName($partida);

            //En caso de que la partida ya exista
            if(!isset($_SESSION["partidaActual"])){
                header("Location:/quizquest/lobbyusuario/get");
                return;
            }
            //Si existe nos vamos al juego
            $_SESSION["indicePregunta"] = 0;
            header("Location:/quizquest/juego/get");
        }


        public function exit(){
            $_SESSION["usuarioLogged"] = null;
            unset($_SESSION["usuarioLogged"]);
            header("Location:/quizquest/login/get");
        }

    }
?>