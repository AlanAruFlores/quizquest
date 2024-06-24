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
            $usuarioDatos = $this->rankingModel->obtenerTopUsuarioId($_SESSION["usuarioLogged"]["id"]);
            // var_dump($usuarioDatos);
            // die();

            //$obtenerPartidasJugador = $this->rankingModel->obtenerPartidasJugador();
            $this->presenter->render("view/viewRanking.mustache", ["usuarioDatos"=>$usuarioDatos,"usuariosTop"=>$usuariosTop,...$this->mainSettings]);
        }

        public function showQrCode(){
            $fileName = "public/imagenes/qr/qrusuario.png";
            $rutaArchivo = "/quizquest/public/imagenes/qr/qrusuario.png";
            QRcode::png("192.168.0.213/quizquest/perfil/showPerfil",$fileName,"M",3,4);
            echo '<img src="'.$rutaArchivo.'" alt="qr">';
            // QRcode::png("192.168.0.213/quizquest/perfil/showPerfil", false , QR_ECLEVEL_L, 10, 7);
        }
    }
?>