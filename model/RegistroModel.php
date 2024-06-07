<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Usamos estas librerias
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//Create an instance; passing `true` enables exceptions

class RegistroModel{
    private $database;
    public function __construct($database){
        $this->database = $database;
    }

    public function sendValidation(){
        $code = self::generateCodeVerification();

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host="smtp.gmail.com";
        $mail->SMTPAuth=true;
        $mail->Username="alangta242@gmail.com";
        $mail->Password="oleqblfrrirfartl";
        $mail->SMTPSecure="ssl";
        $mail->Port=465;
    
        $mail->setFrom("alangta242@gmail.com");
        $mail->addAddress($_POST["email"]);
        $mail->isHTML(true);
        
        $mail->Subject = "Verificacion de registro";
        $mail->Body = "<h1>Codigo de Verificacion</h1><br>Tu codigo de verificacion es $code<br><a href='http://localhost/quizquest/registro/validate'>Ingresa el codigo de verificacion</a>";

        $mail->send();

        echo"<script> alert('Enviado'); </script>";
    
    }
    
    public function verifyIfValidationWasSuccess($codeData){
        if($codeData == $_SESSION["code_verification"])
            return true;
        return false;
    }
    private function generateCodeVerification(){
        $code = rand(1000, 9999);
        $_SESSION["code_verification"] = $code;
        return $code;
    }


    //Registrar usuario
    public function registerNewUser($usuario){
        $sql = "INSERT INTO Usuario (nombreCompleto, rol, imagen, esHabilitado, anoNacimiento, Sexo, CorreoElectronico, contrasena, nombrerUsuario, puntaje, localidad_id)
        VALUES ('".$usuario->getNombreCompleto()."', '".$usuario->getRol()."', '".$usuario->getImagen()."',1, '".$usuario->getAnoNacimiento()."', '".$usuario->getSexo()."', '".$usuario->getCorreoElectronico()."', '".$usuario->getContrasena()."', '".$usuario->getNombreUsuario()."', ".$usuario->getPuntaje().", ".$usuario->getLocalidadId().")";

        $this->database->execute($sql);
    }
}


?>