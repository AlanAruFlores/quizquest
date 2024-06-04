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

            // Evitamos que cambie de pregunta:
            if(isset($_SESSION["preguntaActualExistente"])){
                $this->presenter->render("view/viewJuego.mustache", [
                    "partidaActual"=>$partida,
                    "preguntaActual" => $_SESSION["preguntaActualExistente"],
                    "respuestasActuales" => $_SESSION["respuestas_actuales"],
                    ...$this->mainSettings]);
                return ;
            }
            
            //Cambiamos la pregunta y sus respuestas , ademas, la establecemos con la sesion
            $_SESSION["indicePregunta"] += 1; //Contador para incrementar las perguntas
            // Obtengo respuestas aleatorias
            $preguntaActual = $_SESSION["preguntasActuales"][$indexSiguientePregunta];
            $_SESSION["preguntaActualExistente"] = $preguntaActual;
            
            $respuestasActuales = $this->respuestaModel->getRespuestaByPreguntaId($preguntaActual["id"]);
            $_SESSION["respuestas_actuales"] = $respuestasActuales;
            
            $this->presenter->render("view/viewJuego.mustache", [
                "partidaActual"=>$partida,
                "preguntaActual" => $preguntaActual,
                "respuestasActuales" => $respuestasActuales,
                ...$this->mainSettings]);
        }

        public function selectAnswer(){
            $idRespuestaSeleccionada = $_GET["idRespSeleccionada"];
            $respuestaSeleccionaObject = $this->respuestaModel->getRespuestaByRespuestaIdAndPreguntaId($idRespuestaSeleccionada,$_SESSION["preguntaActualExistente"]["id"]);
            var_dump($respuestaSeleccionaObject);
            
            $estaEquivocado = false;
            if($respuestaSeleccionaObject["esCorreto"]=="0")
                $estaEquivocado = true;

            $this->presenter->render("view/viewJuego.mustache", [
                "partidaActual"=>$_SESSION["partidaActual"],
                "preguntaActual" => $_SESSION["preguntaActualExistente"],
                "respuestasActuales" => $_SESSION["respuestas_actuales"],
                "hayPopUp" => true,
                "popUpCorrectoOError" => $estaEquivocado,
                    ...$this->mainSettings]);
        }


        public function goToNextQuestion(){
            unset($_SESSION["preguntaActualExistente"]);
            header("Location:/quizquest/juego/get");
        }

    }


?>