<?php

    class BotController{
    
        private $botCode;
        private $presenter;
        private $usuarioModel;
        private $preguntaModel;
        private $respuestaModel;
        private $usuarioPreguntaModel;

        public function __construct($presenter, $usuarioModel, $preguntaModel, $respuestaModel, $usuarioPreguntaModel){
            $this->botCode = 100;
            $this->presenter = $presenter;
            $this->usuarioModel = $usuarioModel;
            $this->preguntaModel = $preguntaModel;
            $this->respuestaModel = $respuestaModel;
            $this->usuarioPreguntaModel = $usuarioPreguntaModel;
        }

        public function get(){
            
            $isBotEasy = ($_SESSION["usuarioLogged"]["nivel"] == "AVANZADO") ? false : true;
            $pregunta = $this->preguntaModel->getPreguntaNoRepeatedForBot($this->botCode);
            // var_dump($pregunta);
            // die();
            $respuestas = $this->respuestaModel->getRespuestaByPreguntaId($pregunta["id"]);
            $this->usuarioPreguntaModel->insertNewUsuarioPregunta(new UsuarioPregunta($pregunta["id"],$this->botCode));

            $acerto = self::isAnswerCorrectly($isBotEasy,$pregunta,$respuestas);


            // Devolver solo los datos necesarios del temporizador
            
            if($acerto){
                $_SESSION["botPuntaje"] += 10;
                $_SESSION["botAcerto"] = true;
            }
            else{
                $_SESSION["botAcerto"] = false;
            }

            header('Content-Type: application/json');
            echo json_encode(array(
                'botPuntaje' => $_SESSION["botPuntaje"],
                'acerto' => $_SESSION["botAcerto"]
            ));
        }

        public function isAnswerCorrectly($isBotEasy, $pregunta, $respuestas){
            if(!$isBotEasy){ //Si es dificil
                $num = rand(1,15);
                if($num != 10)
                    return true;
                
                $opcionElegida = rand(1,sizeof($respuestas));
                
                if($respuestas[$opcionElegida]["esCorreto"] == 1)
                    return true;

                return false; //Pierde bot
            }


            //MODO FACIL
            $num = rand(1,5);
            if($num != 3)
                return true;
            
            $opcionElegida = rand(1,sizeof($respuestas));          
            if($respuestas[$opcionElegida]["esCorreto"] == 1)
                return true;
            return false; //Pierde bot
        }



    }

?>