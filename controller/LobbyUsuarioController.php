
<?php 
    class LobbyUsuarioController{

        private $mainSettings;
        private $presenter;

        public function __construct($presenter, $mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
        }

        public function get(){
            $this->presenter->render("view/viewLobbyUsuario.mustache",[...$this->mainSettings]);
        }

        public function exit(){
            $_SESSION["usuarioLogged"] = null;
            unset($_SESSION["usuarioLogged"]);
            header("Location:/quizquest/login/get");
        }

    }
?>