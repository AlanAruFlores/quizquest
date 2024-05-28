<?php 

    class RegistroController{
        private $presenter;
        private $registroModel;
        private $mainSettings;

        public function __construct($presenter,$registroModel, $mainSettings){
            $this->presenter = $presenter;
            $this->registroModel = $registroModel;
            $this->mainSettings = $mainSettings;
        }

        public function get(){
            $this->presenter->render("view/registro.mustache", [...$this->mainSettings]);
        }

        public function validate(){
            if(!isset($_SESSION["code_verification"]))
                $this->registroModel->sendValidation();
         
            $this->presenter->render("view/viewValidar.mustache",[...$this->mainSettings]);
        }

        public function validateFormulario(){
            $codeData = $_POST["numero1"].$_POST["numero2"].$_POST["numero3"].$_POST["numero4"];
            $isSuccess = $this->registroModel->verifyIfValidationWasSuccess($codeData);
            
            if($isSuccess){
                unset($_SESSION["code_verification"]);
                $_SESSION["code_verification"] = null;
                
                $_SESSION["usuarioLogged"] = true;
                header("Location:/quizquest/lobbyusuario/get");
                return ;
            }
            header("Location:/quizquest/registro/validate");
        }
    }
?>