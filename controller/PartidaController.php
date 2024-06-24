<?php 

    class PartidaController{

        private $presenter;
        private $partidaModel;
        private $mainSettings;

        public function __construct($presenter,$partidaModel, $mainSettings){
            $this->presenter = $presenter;
            $this->partidaModel = $partidaModel;
            $this->mainSettings = $mainSettings;
        }

        public function get(){
            $partidas = $this->partidaModel->obtenerPartidasJugador();
            $this->presenter->render("view/viewPartidas.mustache", [
                "partidas"=>$partidas,...$this->mainSettings]);
        }

        

    }

?>