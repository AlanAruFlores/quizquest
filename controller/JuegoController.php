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

        //Muestra las preguntas y sus respuestas.
        public function get(){
            
            //Pregunta actual a responder y preparo sus respuestas
            if(!isset($_SESSION["preguntaActualExistente"])){         
                $_SESSION["preguntaActualExistente"] = $_SESSION["preguntasActuales"][$_SESSION["indicePregunta"]];
                $_SESSION["respuestas_actuales"] = $this->respuestaModel->getRespuestaByPreguntaId($_SESSION["preguntaActualExistente"]["id"]);
                //Itero para la siguiente pregunta que venga
                $_SESSION["indicePregunta"] += 1; 
            }
            
            $this->presenter->render("view/viewJuego.mustache", [
                "partidaActual"=>$_SESSION["partidaActual"],
                "preguntaActual" => $_SESSION["preguntaActualExistente"],
                "respuestasActuales" => $_SESSION["respuestas_actuales"],
                ...$this->mainSettings]);
        }

        //Se ejecuta cuando seleccion una respuesta
        public function selectAnswer(){
            //Obtengo la respuesta seleccionada
            $respuestaSeleccionadaObject = $this->respuestaModel->getRespuestaByRespuestaIdAndPreguntaId($_GET["idRespSeleccionada"],$_SESSION["preguntaActualExistente"]["id"]);
            
            //Veo si se equivoco o no
            $estaEquivocado = $respuestaSeleccionadaObject["esCorreto"]=="0" ? true : false;

            //Retorno el popup con el mensaje correspondiente
            $this->presenter->render("view/viewJuego.mustache", [
                "partidaActual"=>$_SESSION["partidaActual"],
                "preguntaActual" => $_SESSION["preguntaActualExistente"],
                "respuestasActuales" => $_SESSION["respuestas_actuales"],
                "hayPopUp" => true,
                "popUpCorrectoOError" => $estaEquivocado,
                    ...$this->mainSettings]);
        }


        //Se ejecuta cuando apretamos el boton del popup
        public function goToNextQuestion(){
            unset($_SESSION["preguntaActualExistente"]);
            header("Location:/quizquest/juego/get");
        }

    }


?>