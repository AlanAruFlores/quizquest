<?php 

    class RankingController{
        private $presenter;
        private $mainSettings;
        private $rankingModel;

        public function __construct($presenter, $rankingModel, $mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
            $this->rankingModel = $rankingModel;
        }

        public function get(){
            $usuariosTop = $this->rankingModel->obtenerTop();
            /*
            var_dump($usuariosTop);
            die();
                */
            $usuarioDatos = $this->rankingModel->obtenerTopUsuarioId($usuariosTop);
            $obtenerPartidasJugador = $this->rankingModel->obtenerPartidasJugador();
            

            $this->presenter->render("view/viewRanking.mustache", ["obtenerPartidasJugador"=>$obtenerPartidasJugador,"usuarioDatos"=>$usuarioDatos,"usuariosTop"=>$usuariosTop,...$this->mainSettings]);

        }
    }
?>