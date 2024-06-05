<?php
include_once ("model/Pregunta.php");
include_once ("model/Respuesta.php");
include_once("model/UsuarioPregunta.php");
class JuegoController
{

    private $presenter;
    private $mainSettings;
    private $partidaModel;
    private $preguntaModel;
    private $usuarioPreguntaModel;
    private $respuestaModel;
    public function __construct($presenter, $partidaModel, $preguntaModel, $respuestaModel, $usuarioPreguntaModel, $mainSettings)
    {
        $this->presenter = $presenter;
        $this->partidaModel = $partidaModel;
        $this->preguntaModel = $preguntaModel;
        $this->usuarioPreguntaModel = $usuarioPreguntaModel;
        $this->mainSettings = $mainSettings;
        $this->respuestaModel = $respuestaModel;
    }

    //Muestra las preguntas y sus respuestas.
    public function get()
    {


        if($_SESSION["indicePregunta"] >=10){
            unset($_SESSION["preguntaActualExistente"]);
            unset($_SESSION["isPlaying"]);
            echo "terminado";
            die();
        }

        //Pregunta actual a responder y preparo sus respuestas
        if (!isset($_SESSION["preguntaActualExistente"])) {
            $_SESSION["preguntaActualExistente"] = $this->preguntaModel->generateARandomQuestion($_SESSION["partidaActual"]["puntaje"]);
            $_SESSION["respuestasActuales"] = $this->respuestaModel->getRespuestaByPreguntaId($_SESSION["preguntaActualExistente"]["id"]);
            $up = new UsuarioPregunta($_SESSION["preguntaActualExistente"]["id"], $_SESSION["usuarioLogged"]["id"]);
            $this->usuarioPreguntaModel->insertNewUsuarioPregunta($up);
            //Itero para la siguiente pregunta que venga
            $_SESSION["levelOfQuestion"] = ($_SESSION["partidaActual"]["puntaje"] <= 50 && $_SESSION["partidaActual"]["puntaje"] >= 0) ? "FACIL" :
            (($_SESSION["partidaActual"]["puntaje"] >50 && $_SESSION["partidaActual"]["puntaje"] <=80) ? "INTERMEDIO": "DIFICIL");
           
            $_SESSION["indicePregunta"] += 1;
        }

        $colorDificultad  = "";

        if($_SESSION["levelOfQuestion"] == "FACIL")
            $colorDificultad  = "#339900";
        else if($_SESSION["levelOfQuestion"] == "INTERMEDIO")
            $colorDificultad  = "#ffcc00";
        else
            $colorDificultad = "#cc3300";


        $this->presenter->render("view/viewJuego.mustache", [
            "partidaActual" => $_SESSION["partidaActual"],
            "preguntaActual" => $_SESSION["preguntaActualExistente"],
            "respuestasActuales" => $_SESSION["respuestasActuales"],
            "nivelPregunta" => $_SESSION["levelOfQuestion"],
            "colorDificultad" => $colorDificultad,
            ...$this->mainSettings
        ]);
    }

    //Se ejecuta cuando seleccion una respuesta
    public function selectAnswer()
    {
        //Obtengo la respuesta seleccionada
        $respuestaSeleccionadaObject = $this->respuestaModel->getRespuestaByRespuestaIdAndPreguntaId($_GET["idRespSeleccionada"], $_SESSION["preguntaActualExistente"]["id"]);
      
        //Veo si se equivoco o no
        $estaEquivocado = $respuestaSeleccionadaObject["esCorreto"] == "0" ? true : false;
        $this->preguntaModel->increaseCantidadOfPregunta($_SESSION["preguntaActualExistente"]);
        //Si acierta
        if (!$estaEquivocado) {
            $_SESSION["partidaActual"] = $this->partidaModel->increasePartidaPoints($_SESSION["partidaActual"], $_SESSION["preguntaActualExistente"]["punto"]);
            $this->preguntaModel->increaseAcertadasOfPregunta($_SESSION["preguntaActualExistente"]);
        }
        $this->preguntaModel->updatePorcentaje($_SESSION["preguntaActualExistente"]);

        //Retorno el popup con el mensaje correspondiente
        $this->presenter->render("view/viewJuego.mustache", [
            "partidaActual" => $_SESSION["partidaActual"],
            "preguntaActual" => $_SESSION["preguntaActualExistente"],
            "respuestasActuales" => $_SESSION["respuestasActuales"],
            "hayPopUp" => true,
            "popUpCorrectoOError" => $estaEquivocado,
            ...$this->mainSettings
        ]);
    }


    //Se ejecuta cuando apretamos el boton del popup
    public function goToNextQuestion()
    {
        unset($_SESSION["preguntaActualExistente"]);
        header("Location:/quizquest/juego/get");
    }

}


?>