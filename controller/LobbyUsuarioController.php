
<?php 
    include_once("model/Partida.php");
    include_once("model/Pregunta.php");
    include_once("model/UsuarioPartidaPregunta.php");

    class LobbyUsuarioController{

        private $mainSettings;
        private $presenter;
        private $partidaModel;
        private $usuarioPartidaPreguntaModel;
        private $preguntaModel;
        public function __construct($presenter,$partidaModel,$preguntaModel,$usuarioPartidaPreguntaModel,$mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
            $this->partidaModel = $partidaModel;
            $this->preguntaModel = $preguntaModel;
            $this->usuarioPartidaPreguntaModel = $usuarioPartidaPreguntaModel;

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

            //Obtengo el usuario logeado
            $usuarioObject = $_SESSION["usuarioLogged"];
            $preguntasGeneradas = $this->preguntaModel->generateRandomPreguntas();

            //Establezco registros de la tabla "realiza"
            foreach ($preguntasGeneradas as $preguntaItem) {
                $upp = new UsuarioPartidaPregunta($partidaObject["id"],$preguntaItem["id"],$usuarioObject["id"]);
                $this->usuarioPartidaPreguntaModel->insertNewUsuarioPartidaPregunta($upp);
            }

            //Preparo las preguntas y su contador de preguntas
            $_SESSION["preguntasActuales"] = $this->preguntaModel->getRandomPreguntas();
            
            $_SESSION["indicePregunta"] = 0;
            header("Location:/quizquest/juego/get");
        }


        public function exit(){
            unset($_SESSION["usuarioLogged"]);
            header("Location:/quizquest/login/get");
        }

    }
?>