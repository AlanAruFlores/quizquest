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

            /*Guardo en la sesion al usuario*/
            $_SESSION["usuarioLogged"] = $usuarioEncontrado;

            /*Si es editor lo mando a su vista */
            if($usuarioEncontrado["rol"] == "Editor"){
                header("Location:/quizquest/lobbyeditor/get");
                return;
            }

            /*Si es admin lo mando a su vista */
            if($usuarioEncontrado["rol"] == "Administrador"){
                header("Location:/quizquest/adminpanel/get");
                return;
            }
            
            /*Si no es editor ni administrador, es un usuario normal */
            header("Location:/quizquest/lobbyusuario/get");
        }
    }
?>