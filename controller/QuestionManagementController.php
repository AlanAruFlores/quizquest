<?php

    class QuestionManagementController{
        private $presenter;
        private $mainSettings;
        private $preguntaModel;
        private $respuestaModel;
        private $categoriaModel;

        public function __construct($presenter,$preguntaModel,$respuestaModel,$categoriaModel, $mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
            $this->preguntaModel = $preguntaModel;
            $this->respuestaModel = $respuestaModel;
            $this->categoriaModel= $categoriaModel;
        }


        public function get(){
            $arrayPreguntas = $this->preguntaModel->getAllPreguntas();

            $this->presenter->render("view/viewQuestionManagement.mustache",
            ["preguntas"=>$arrayPreguntas, ...$this->mainSettings]);
        }

        public function goToEdit(){

            //Obtengo la pregunta con sus respuestas
            $pregunta = $this->preguntaModel->getPreguntaWithCategoria($_GET["id"]); 
            $categorias = $this->categoriaModel->getAllCategoriasBasedPreguntaCategoria($pregunta);
            /*
            var_dump($categorias);
            die();
            */

            $respuestasAux  = $this->respuestaModel->getRespuestaByPreguntaId($_GET["id"]); //[[... , ...] , [...., ...]]
            $respuestas = [];
            foreach($respuestasAux as $respuesta){
                $respuesta["esCorreto"] = $respuesta["esCorreto"] == "1" ? true : false;
                $respuestas[]  = $respuesta;
            }

            
            $this->presenter->render("view/viewEditQuestion.mustache", [
                "pregunta" => $pregunta,
                "respuestas" => $respuestas,
                "categorias" => $categorias,
                ...$this->mainSettings
            ]);
        }
    

    }


?>