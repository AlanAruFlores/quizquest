<?php 
    include_once("model/Temporizador.php");
    class ContarController{
        private $presenter;
        public function __construct($presenter){
            $this->presenter = $presenter;
        }

        public function get(){

            if(!isset($_SESSION["temporizador"]))
                $_SESSION["temporizador"] = serialize(new Temporizador(20)); //SERIALIZA EL OBJETO PARA GUARDAR EN LA SESSION

            //DESERIALIZA LOS BYTES AL OBJETO TEMPORIZADOR
            $temporizador = unserialize($_SESSION["temporizador"]);

            $temporizador->setSegundos($temporizador->getSegundos()-1);        
            $_SESSION["temporizador"] = serialize($temporizador);

            // var_dump(unserialize($_SESSION["temporizador"])->getSegundos());
            // var_dump($temporizador->getSegundos());
            // Establecer el tipo de contenido como JSON
            header('Content-Type: application/json');
            
            // Devolver solo los datos necesarios del temporizador
            echo json_encode(array(
                'segundos' => $temporizador->getSegundos() 
            ));
    
        }
    }  
?>