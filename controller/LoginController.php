<?php   
    include_once("model/Usuario.php");

    class LoginController{
        private $presenter;
        private $mainSettings;

        private $usuarioModel;
        public function __construct($presenter, $usuarioModel, $mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
            $this->usuarioModel = $usuarioModel;
        }

        public function get(){
            $this->presenter->render("view/login.mustache", [...$this->mainSettings]);
        }

        public function verifyLogin(){
            if(!isset($_POST["correo_electronico"]) || !isset($_POST["contrasena"])){
                header("Location:/quizquest/login/get");
                return;
            }
            $usuario = new Usuario();
            $usuario->setCorreoElectronico($_POST["correo_electronico"]);
            $usuario->setContrasena($_POST["contrasena"]);
            $usuarioEncontrado = $this->usuarioModel->findUserByEmailandPassword($usuario);

            if(!$usuarioEncontrado){
                header("Location:/quizquest/login/get");
                return;
            }
            $_SESSION["usuarioLogged"] = $usuarioEncontrado;

            header("Location:/quizquest/lobbyusuario/get");
        }
    }
?>