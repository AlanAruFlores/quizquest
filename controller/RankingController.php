<?php 
    include_once("third-party/phpqrcode/qrlib.php");

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

        public function showQrCode(){
            QRcode::png("192.168.0.213/quizquest/perfil/showPerfil", false , QR_ECLEVEL_L, 10, 7);
        }
    }
?>