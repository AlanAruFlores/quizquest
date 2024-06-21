<?php
include_once("model/Pregunta.php");
include_once("model/Respuesta.php");
class QuestionManagementController
{
    private $presenter;
    private $mainSettings;
    private $preguntaModel;
    private $respuestaModel;
    private $categoriaModel;
    private $reportaModel;
    private $usuarioPreguntaModel;

    public function __construct($presenter, $preguntaModel, $respuestaModel, $categoriaModel, $reportaModel, $usuarioPreguntaModel, $mainSettings)
    {
        $this->presenter = $presenter;
        $this->mainSettings = $mainSettings;
        $this->preguntaModel = $preguntaModel;
        $this->respuestaModel = $respuestaModel;
        $this->categoriaModel = $categoriaModel;
        $this->reportaModel = $reportaModel;
        $this->usuarioPreguntaModel = $usuarioPreguntaModel;
    }


    public function get()
    {
        $arrayPreguntas = $this->preguntaModel->getAllPreguntas();

        $this->presenter->render(
            "view/viewQuestionManagement.mustache",
            ["preguntas" => $arrayPreguntas, ...$this->mainSettings]
        );
    }

    public function goToEdit()
    {

        //Obtengo la pregunta con sus respuestas
        $pregunta = $this->preguntaModel->getPreguntaWithCategoria($_GET["id"]);
        $categorias = $this->categoriaModel->getAllCategoriasBasedPreguntaCategoria($pregunta);
        /*
        var_dump($pregunta);
        die();
        */

        $respuestasAux = $this->respuestaModel->getRespuestaByPreguntaId($_GET["id"]); //[[... , ...] , [...., ...]]
        $respuestas = [];
        foreach ($respuestasAux as $respuesta) {
            $respuesta["esCorreto"] = $respuesta["esCorreto"] == "1" ? true : false;
            $respuestas[] = $respuesta;
        }

        // var_dump($respuestas);
        // die();

        $this->presenter->render("view/viewEditQuestion.mustache", [
            "pregunta" => $pregunta,
            "respuestas" => $respuestas,
            "categorias" => $categorias,
            ...$this->mainSettings
        ]);
    }

    public function addNewQuestion()
    {
        //Instancio las preguntas y respuestas nuevas y a sugerir
        $lastIdPregunta = $this->preguntaModel->getLastPreguntaId();
        $this->preguntaModel->createNewPregunta(new Pregunta($lastIdPregunta,10,true,$_POST["descripcionPregunta"],$_POST["preguntaCategoriaId"]));
        
        $respuestasNuevas = [];
        for($i = 1; $i<=intval($_POST["cantidadPreguntas"]); $i++)
            $respuestasNuevas[] = new Respuesta(null, ($i== $_POST["esCorrecta"]) ? TRUE : FALSE,$_POST["respuesta$i"], $lastIdPregunta);
        
        $this->respuestaModel->createAllRespuestas($respuestasNuevas);
        header("Location:/quizquest/questionmanagement/get");
    }

    public function editQuestion()
    {
        //Busco y actualizo la pregunta
        $pregunta = $this->preguntaModel->getPreguntaWithCategoria($_POST["pregunta_id"]);
        $pregunta["descripcion"] = $_POST["preguntaDescripcion"];
        $pregunta["categoria_id"] = $_POST["categoriaPregunta"];
        $this->preguntaModel->updateDescripcionAndCategoriaPregunta($pregunta);


        //Obtener todas las respuestas del POST y las actualizo
        $respuestasAux = $this->respuestaModel->getRespuestaByPreguntaId($pregunta["id"]); //[[... , ...] , [...., ...]]
        foreach ($respuestasAux as $respuesta) {
            $respuesta["descripcion_respuesta"] = $_POST["respuesta" . $respuesta["res_id"]];
            $respuesta["esCorreto"] = $_POST["esCorrecto"] == $respuesta["res_id"] ? true : false;
            $this->respuestaModel->updateRespuesta($respuesta);
        }

        // var_dump($respuestas);
        // die();

        header("Location:/quizquest/questionmanagement/goToEdit?id=" . $pregunta["id"]);
    }

    public function deleteQuestion()
    {
        /*La eliminamos de reporta y realiza tablas */
        $this->reportaModel->deletePreguntasById($_GET["id"]);
        $this->usuarioPreguntaModel->deletePreguntasById($_GET["id"]);
        $this->respuestaModel->deleteRespuestasByPreguntaId($_GET["id"]);
        $this->preguntaModel->deletePreguntaById($_GET["id"]);

        header("Location:/quizquest/questionmanagement/get");
    }
}


?>