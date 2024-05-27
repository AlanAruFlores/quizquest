<?php 

    class PerfilController{
        private $presenter;
        private $mainSettings;

        public function __construct($presenter, $mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
        }

        public function get(){
            $this->presenter->render("view/Perfil.mustache", [...$this->mainSettings]);
        }
    }
?>