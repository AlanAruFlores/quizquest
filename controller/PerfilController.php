<?php 

    class PerfilController{
        private $presenter;
        private $mainSettings;

        public function __construct($presenter, $mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
        }

        public function get(){  
            $usuarioLogeado = $_SESSION["usuarioLogged"];
            $this->presenter->render("view/Perfil.mustache",
            [
                "usuarioLogeado"=>$usuarioLogeado,    
                ...$this->mainSettings
            ]);
        }

        public function showPerfil(){
            //$idUsuario = $_GET["id"];
            $this->presenter->render("view/viewShowPerfil.mustache",
            [
                ...$this->mainSettings
            ]);
            
        }
    }
?>