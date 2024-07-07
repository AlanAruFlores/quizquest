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
            
            //Establecer el nivel del bot
            $isBotEasy = ($_SESSION["usuarioLogged"]["nivel"] == "AVANZADO") ? false : true;

            //Retorna una pregunta aleotoria no repetida
            $pregunta = $this->preguntaModel->getPreguntaNoRepeatedForBot($this->botCode); // ID: 100
            // var_dump($pregunta);
            // die();

            //Retorna las respuestas posibles de una pregunta
            $respuestas = $this->respuestaModel->getRespuestaByPreguntaId($pregunta["id"]);

            //Registrar que preguntas fue respondiendo (tabla 'Realiza')
            $this->usuarioPreguntaModel->insertNewUsuarioPregunta(new UsuarioPregunta($pregunta["id"],$this->botCode));

            $acerto = self::isAnswerCorrectly($isBotEasy,$pregunta,$respuestas);


            // Devolver solo los datos necesarios del temporizador
            
            if($acerto){
                $_SESSION["botPuntaje"] += 10;
                $_SESSION["botAcerto"] = true;
            }
            else{
                $_SESSION["botAcerto"] = false; //Se pinta en rojo y deja de contestar
            }

            header('Content-Type: application/json'); //TIPO DE RESPUESTA: JSON
            echo json_encode(array(
                'botPuntaje' => $_SESSION["botPuntaje"],
                'acerto' => $_SESSION["botAcerto"]
            )); //CONVIERTO EL ARREGLO A UN JSON
        }


        //Devuelve si el bot acerto o no  (true/false).
        public function isAnswerCorrectly($isBotEasy, $pregunta, $respuestas){

            //MODO DIFICIL
            if(!$isBotEasy){ //Si es dificil
                $num = rand(1,15);
                if($num != 10)
                    return true;
                
                //obtengo un numero entre 1 y la cantidad de respuestas del arreglo del mismo
                $opcionElegida = rand(1,sizeof($respuestas));
                
                if($respuestas[$opcionElegida]["esCorreto"] == 1)
                    return true;

                return false; //Pierde bot
            }

            //-----------------------

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