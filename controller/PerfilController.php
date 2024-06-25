<?php 

    class PerfilController{
        private $presenter;
        private $mainSettings;
        private $usuarioModel;
        private $partidaModel;
        public function __construct($presenter,$usuarioModel,$partidaModel,$mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
            $this->usuarioModel = $usuarioModel;
            $this->partidaModel = $partidaModel;
        }

        public function get(){  
            $usuarioLogeado = $_SESSION["usuarioLogged"];
            
            //Genero su qr
            $file = "qrusuario".$usuarioLogeado["id"];
            $path = "public/imagenes/qr/$file.png";
            $fullPath ="/quizquest/$path";
            QRcode::png("192.168.8.254/quizquest/perfil/showPerfil?id=".$usuarioLogeado["id"],$path,"M",4,4);
            
            $this->presenter->render("view/Perfil.mustache",
            [
                "usuarioLogeado"=>$usuarioLogeado,
                "fullPath" => $fullPath,    
                ...$this->mainSettings
            ]);
        }

        public function showPerfil(){
            $idUsuario = $_GET["id"];
            $usuario = $this->usuarioModel->findById($idUsuario);
            $partidasRecientes = $this->partidaModel->getPartidasRecientes($idUsuario);
            $this->presenter->render("view/viewShowPerfil.mustache",
            [
                "usuario" => $usuario,
                "partidaRecientes" => $partidasRecientes,
                ...$this->mainSettings
            ]);
        }

        public function actualizarPerfil() {
                // Aquí deberías validar y sanitizar los datos del formulario antes de pasarlos al modelo
                // var_dump($_POST);
                // die();
                $datosActualizados = [
                    "id" => $_SESSION["usuarioLogged"]["id"],
                    "nombreCompleto" => $_POST["nombreCompleto"],
                    "rol" => $_SESSION["usuarioLogged"]["rol"],
                    "imagen" => $_SESSION["usuarioLogged"]["imagen"],
                    "esHabilitado" => $_SESSION["usuarioLogged"]["esHabilitado"],
                    "fechaNacimiento" => $_POST["fechaNacimiento"],
                    "Sexo" => $_POST["sexo"],
                    "CorreoElectronico" => $_POST["correoelectronico"],
                    "contrasena" => $_POST["contrasena"],
                    "nombrerUsuario" => $_POST["nombreUsuario"],
                    "pais" => $_POST["pais"],
                    "ciudad" => $_POST["ciudad"],
                    "cantidad_dadas" => $_SESSION["usuarioLogged"]["cantidad_dadas"],
                    "cantidad_acertadas" => $_SESSION["usuarioLogged"]["cantidad_acertadas"],
                    "ratio" => $_SESSION["usuarioLogged"]["ratio"],
                    "nivel" => $_SESSION["usuarioLogged"]["nivel"]
                ];
    
                // var_dump($datosActualizados);
                // die();
                $this->usuarioModel->update($datosActualizados);
                $_SESSION["usuarioLogged"] = $this->usuarioModel->findById($_SESSION["usuarioLogged"]["id"]);
                header("Location:/perfil");
        }
    }
?>