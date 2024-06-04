<?php
    include_once("model/Pregunta.php");
    include_once("model/Respuesta.php");

    class JuegoController{

        private $presenter;
        private $mainSettings;
        private $preguntaModel;
        private $respuestaModel;
        public function __construct($presenter,$preguntaModel,$respuestaModel, $mainSettings){
            $this->presenter = $presenter;
            $this->preguntaModel = $preguntaModel;
            $this->mainSettings = $mainSettings;
            $this->respuestaModel =$respuestaModel;
        }

        public function get(){
            $partida = $_SESSION["partidaActual"];
            $indexSiguientePregunta = $_SESSION["indicePregunta"];
            $_SESSION["indicePregunta"] += 1; //Contador para incrementar las perguntas

            // Obtengo respuestas aleatorias
            $preguntasDeLaPartida = $this->preguntaModel->getRandomPreguntas();
            /*
            var_dump($preguntasDeLaPartida);
            die();*/
            $preguntaActual = $preguntasDeLaPartida[$indexSiguientePregunta];
            
            $respuestasActuales = $this->respuestaModel->getRespuestaByPreguntaId($preguntaActual["id"]);
            
            
            // var_dump($respuestasActuales);
            // die();
            $this->presenter->render("view/viewJuego.mustache", [
                "partidaActual"=>$partida,
                "preguntaActual" => $preguntaActual,
                "respuestasActuales" => $respuestasActuales,
                ...$this->mainSettings]);
        }


        public function verifyAnswer(){

        }
    }


?>