<?php
include_once ("model/Pregunta.php");
include_once ("model/Respuesta.php");
include_once("model/UsuarioPregunta.php");
include_once("model/reporta.php");

class JuegoController
{

    private $presenter;
    private $mainSettings;
    private $partidaModel;
    private $preguntaModel;
    private $usuarioPreguntaModel;
    private $respuestaModel;
    private $reporteModel;
    private $usuarioModel;

    public function __construct($presenter, $partidaModel, $preguntaModel, $respuestaModel, $usuarioPreguntaModel,$reporteModel,$usuarioModel, $mainSettings)
    {
        $this->presenter = $presenter;
        $this->partidaModel = $partidaModel;
        $this->preguntaModel = $preguntaModel;
        $this->usuarioPreguntaModel = $usuarioPreguntaModel;
        $this->mainSettings = $mainSettings;
        $this->respuestaModel = $respuestaModel;
        $this->reporteModel = $reporteModel;
        $this->usuarioModel = $usuarioModel;
    }

    //Muestra las preguntas y sus respuestas.
    public function get()
    {

        //Si se equivoco termina el juego
        if(isset($_SESSION["isIncorrectQuestion"]) && $_SESSION["isIncorrectQuestion"] == true){
            header("Location:/quizquest/juego/goToTheEnd");
            return ;
        }

        //Pregunta actual a responder y preparo sus respuestas
        if (!isset($_SESSION["preguntaActualExistente"])) {
            $_SESSION["preguntaActualExistente"] = $this->preguntaModel->generateARandomQuestion($_SESSION["partidaActual"]["puntaje"], $_SESSION["usuarioLogged"]["nivel"]);

            $_SESSION["respuestasActuales"] = $this->respuestaModel->getRespuestaByPreguntaId($_SESSION["preguntaActualExistente"]["id"]);
            $up = new UsuarioPregunta($_SESSION["preguntaActualExistente"]["id"], $_SESSION["usuarioLogged"]["id"]);
            $this->usuarioPreguntaModel->insertNewUsuarioPregunta($up);
            //Itero para la siguiente pregunta que venga
            $_SESSION["levelOfQuestion"] = $this->preguntaModel->getLevelOfQuestion($_SESSION["partidaActual"]["puntaje"],$_SESSION["usuarioLogged"]["nivel"]);
            // ($_SESSION["partidaActual"]["puntaje"] <= 100 &&  >= 0) ? "FACIL" :
            // (($_SESSION["partidaActual"]["puntaje"] > 100 && $_SESSION["partidaActual"]["puntaje"] <=150) ? "INTERMEDIO": "DIFICIL");
           
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
        $usuarioActualizado = $_SESSION["usuarioLogged"];

        //Obtengo la respuesta seleccionada
        $respuestaSeleccionadaObject = $this->respuestaModel->getRespuestaByRespuestaIdAndPreguntaId($_GET["idRespSeleccionada"], $_SESSION["preguntaActualExistente"]["id"]);
      
        //Veo si se equivoco o no
        $estaEquivocado = $respuestaSeleccionadaObject["esCorreto"] == "0" ? true : false;
        
        $this->preguntaModel->increaseCantidadOfPregunta($_SESSION["preguntaActualExistente"]);
        $usuarioActualizado["cantidad_dadas"] += 1;
        //Si acierta
        if (!$estaEquivocado) {
            $_SESSION["partidaActual"] = $this->partidaModel->increasePartidaPoints($_SESSION["partidaActual"], $_SESSION["preguntaActualExistente"]["punto"]);
            $this->preguntaModel->increaseAcertadasOfPregunta($_SESSION["preguntaActualExistente"]);
            $usuarioActualizado["cantidad_acertadas"] += 1;
        }else{
            $_SESSION["isIncorrectQuestion"] = true;
        }
        //Actualizo el usuario
        $usuarioActualizado["ratio"] = ($usuarioActualizado["cantidad_acertadas"] / $usuarioActualizado["cantidad_dadas"]) * 100;
        $this->usuarioModel->update($usuarioActualizado);
        $_SESSION["usuarioLogged"] = $this->usuarioModel->findById($usuarioActualizado["id"]);

        //Actualizo el ratio de la pregunta
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
        unset($_SESSION["temporizador"]);
        unset($_SESSION["preguntaActualExistente"]);
        if($_SESSION["playBot"] == false)
            header("Location:/quizquest/juego/get");
        if($_SESSION["playBot"] == true)
            header("Location:/quizquest/juego/playBot");
    
    }

    public function goToTheEnd(){

        //Si juega solo
        if($_SESSION["playBot"] == false){
            $this->presenter->render("view/viewFinDePartida.mustache", [
                "partidaActual" => $_SESSION["partidaActual"],
                "hayPopUpGanador" => $_SESSION["partidaActual"]["puntaje"] > 100,
                ...$this->mainSettings
            ]);
            return ;
        }

        //Si juega con un bot , debemos esperar al bot y comparar puntaje
            $this->presenter->render("view/viewFinDePartidaBot.mustache", [
                "partidaActual" => $_SESSION["partidaActual"],
                "esperarBot" => $_SESSION["botAcerto"] == true,
                ...$this->mainSettings
            ]);
    }

    public function goToLobby(){
        unset($_SESSION["temporizador"]);
        unset($_SESSION["preguntaActualExistente"]);
        unset($_SESSION["isPlaying"]);
        unset($_SESSION["partidaActual"]);
        unset($_SESSION["isIncorrectQuestion"]);
        unset($_SESSION["playBot"]);
        header("Location:/quizquest/lobbyusuario/get");
    }


    /*METODO PARA REPORTAR UNA PREGUNTA */

    public function reportQuestion(){
        $razon = isset($_POST["razon"]) ? $_POST["razon"] : "Razon indefinida";
        $preguntaId= $_POST["pregunta_id"]; //Id de la pregunta a reportar 
        $usuarioId = $_SESSION["usuarioLogged"]["id"]; // Accedo al id del usuario
        $this->preguntaModel->changePreguntaToInvalidById($preguntaId);

        $nuevoReporte = new Reporta(null,$usuarioId, $preguntaId, $razon);
        $this->reporteModel->insertNewReporte($nuevoReporte);

        header("Location:/quizquest/juego/get");
    }

    /*METODO PARA JUGAR CON EL BOT*/
    public function playBot(){
            //Si se equivoco termina el juego 
            if(isset($_SESSION["isIncorrectQuestion"]) && $_SESSION["isIncorrectQuestion"] == true){
                header("Location:/quizquest/juego/goToTheEnd");
                return ;
            }
    
            //Pregunta actual a responder y preparo sus respuestas
            if (!isset($_SESSION["preguntaActualExistente"])) {
                $_SESSION["preguntaActualExistente"] = $this->preguntaModel->generateARandomQuestion($_SESSION["partidaActual"]["puntaje"], $_SESSION["usuarioLogged"]["nivel"]);
    
                $_SESSION["respuestasActuales"] = $this->respuestaModel->getRespuestaByPreguntaId($_SESSION["preguntaActualExistente"]["id"]);
                $up = new UsuarioPregunta($_SESSION["preguntaActualExistente"]["id"], $_SESSION["usuarioLogged"]["id"]);
                $this->usuarioPreguntaModel->insertNewUsuarioPregunta($up);
                //Itero para la siguiente pregunta que venga
                $_SESSION["levelOfQuestion"] = $this->preguntaModel->getLevelOfQuestion($_SESSION["partidaActual"]["puntaje"],$_SESSION["usuarioLogged"]["nivel"]);
                // ($_SESSION["partidaActual"]["puntaje"] <= 100 &&  >= 0) ? "FACIL" :
                // (($_SESSION["partidaActual"]["puntaje"] > 100 && $_SESSION["partidaActual"]["puntaje"] <=150) ? "INTERMEDIO": "DIFICIL");
               
                $_SESSION["indicePregunta"] += 1;
            }
    
            $colorDificultad  = "";
    
            if($_SESSION["levelOfQuestion"] == "FACIL")
                $colorDificultad  = "#339900";
            else if($_SESSION["levelOfQuestion"] == "INTERMEDIO")
                $colorDificultad  = "#ffcc00";
            else
                $colorDificultad = "#cc3300";
    
    
            $this->presenter->render("view/viewJuegoBot.mustache", [
                "partidaActual" => $_SESSION["partidaActual"],
                "preguntaActual" => $_SESSION["preguntaActualExistente"],
                "respuestasActuales" => $_SESSION["respuestasActuales"],
                "nivelPregunta" => $_SESSION["levelOfQuestion"],
                "colorDificultad" => $colorDificultad,
                ...$this->mainSettings
            ]);
    }
}


?>