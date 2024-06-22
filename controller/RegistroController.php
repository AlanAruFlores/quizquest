<?php
include_once ("model/Usuario.php");

class RegistroController
{
    private $presenter;
    private $registroModel;
    private $usuarioModel;
    private $mainSettings;

    public function __construct($presenter, $registroModel, $usuarioModel, $mainSettings)
    {
        $this->presenter = $presenter;
        $this->registroModel = $registroModel;
        $this->usuarioModel = $usuarioModel;
        $this->mainSettings = $mainSettings;
    }

    public function get()
    {
        $this->presenter->render("view/registro.mustache", [...$this->mainSettings]);
    }

    public function validate()
    {

        $imagen = $_FILES["imagen"];
        $rutaImagen = "/quizquest/public/imagenes/perfiles/".$imagen["name"];
        $usuarioPendiente = new Usuario(null, $_POST["nombre"], "Basico", $rutaImagen, true, $_POST["nacimiento"], $_POST["sexo"], $_POST["email"], $_POST["username"], $_POST["contrasenia"], $_POST["pais"], $_POST["ciudad"]);
        $_SESSION["datosImagen"] = ["rutaImagen" => $rutaImagen, "tmpName" => $imagen["tmp_name"]];
        move_uploaded_file($imagen["tmp_name"], $_SERVER["DOCUMENT_ROOT"].$rutaImagen);



       // die();
//            if(!isset($_SESSION["code_verification"])){
        $this->registroModel->sendValidation();
        $_SESSION["usuarioPendiente"] = serialize($usuarioPendiente);
        //          }
        $this->presenter->render("view/viewValidar.mustache", [...$this->mainSettings]);
    }

    public function validateFormulario()
    {
        $codeData = $_POST["numero1"] . $_POST["numero2"] . $_POST["numero3"] . $_POST["numero4"];
        $isSuccess = $this->registroModel->verifyIfValidationWasSuccess($codeData);

        if ($isSuccess) {
            unset($_SESSION["code_verification"]);
            $_SESSION["code_verification"] = null;
            $this->registroModel->registerNewUser(unserialize($_SESSION["usuarioPendiente"]));
            $_SESSION["usuarioLogged"] = $this->usuarioModel->findUserByEmailandPassword(unserialize($_SESSION["usuarioPendiente"]));
            header("Location:/quizquest/lobbyusuario/get");
            return;
        }
        header("Location:/quizquest/registro/validate");
    }
}
?>