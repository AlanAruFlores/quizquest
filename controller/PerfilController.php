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
            QRcode::png("192.168.0.213/quizquest/perfil/showPerfil?id=".$usuarioLogeado["id"],$path,"M",3,4);
            
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
    }
?>