
<?php 
    include_once("model/Partida.php");

    class LobbyUsuarioController{

        private $mainSettings;
        private $presenter;
        private $partidaModel;
        private $usuarioPartidaPreguntaModel;
        private $preguntaModel;
        public function __construct($presenter,$partidaModel,$mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
            $this->partidaModel = $partidaModel;
        }

        public function get(){
            $this->presenter->render("view/viewLobbyUsuario.mustache",[...$this->mainSettings]);
        }

        public function createNewPartida(){
            //INSERTO Y OBTENGO LA PARTIDA
            $partida = new Partida();
            $partida->setNombre($_POST["nombre"]);
            $partida->setPuntaje(0);
            $this->partidaModel->insertNewPartida($partida);
            $partidaObject= $this->partidaModel->getPartidaByName($partida);
            $_SESSION["partidaActual"] = $partidaObject;
            
            $_SESSION["indicePregunta"] = 0;
            header("Location:/quizquest/juego/get");
        }


        public function exit(){
            unset($_SESSION["usuarioLogged"]);
            header("Location:/quizquest/login/get");
        }

    }
?>