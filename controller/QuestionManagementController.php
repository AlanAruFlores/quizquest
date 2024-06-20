<?php

    class QuestionManagementController{
        private $presenter;
        private $mainSettings;
        private $preguntaModel;
        private $respuestaModel;


        public function __construct($presenter,$preguntaModel,$respuestaModel, $mainSettings){
            $this->presenter = $presenter;
            $this->mainSettings = $mainSettings;
            $this->preguntaModel = $preguntaModel;
            $this->respuestaModel = $respuestaModel;
        }


        public function get(){
            $arrayPreguntas = $this->preguntaModel->getAllPreguntas();

            $this->presenter->render("view/viewQuestionManagement.mustache",
            ["preguntas"=>$arrayPreguntas, ...$this->mainSettings]);
        }

        public function goToEdit(){
            $this->presenter->render("view/viewEditQuestion.mustache", [...$this->mainSettings]);
        }
    

    }


?>