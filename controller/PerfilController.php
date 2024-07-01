<?php 
    include_once("./third-party/phpqrcode/qrlib.php");

    class PerfilController{
        private $presenter;
        private $mainSettings;
        private $usuarioModel;
        private $partidaModel;

        private $rankingModel;
        public function __construct($presenter,$usuarioModel,$partidaModel,$rankingModel, $mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
            $this->usuarioModel = $usuarioModel;
            $this->partidaModel = $partidaModel;
            $this->rankingModel = $rankingModel;
        }

        public function get(){  
            $usuarioLogeado = $_SESSION["usuarioLogged"];        
            //Genero su qr
            $file = "qrusuario".$usuarioLogeado["id"];
            $path = "public/imagenes/qr/$file.png";
            $fullPath ="/quizquest/$path";

            $config = parse_ini_file("config/config.ini");
            $ip=$config["IP"];
            QRcode::png("$ip/quizquest/perfil/showPerfil?id=".$usuarioLogeado["id"],$path,"M",4,4);
            
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
            $ranking = $this->rankingModel->obtenerTopUsuarioId($idUsuario);
            // var_dump($ranking);
            // die();    
            $this->presenter->render("view/viewShowPerfil.mustache",
            [
                "usuario" => $usuario,
                "partidaRecientes" => $partidasRecientes,
                "posicion" => $ranking["top"],
                "maximoPuntaje" => $ranking["max_puntaje"],
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
                header("Location:/quizquest/perfil/get");
        }
    }
?>