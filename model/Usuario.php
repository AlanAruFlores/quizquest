<?php
class Usuario
{
    private $id;
    private $nombreCompleto;
    private $rol;
    private $imagen;    
    private $esHabilitado;
    private $anoNacimiento;
    private $sexo;
    private $correoElectronico;
    private $nombreUsuario;
    private $contrasena;
    private $puntaje;
    private $localidadId;

    public function __construct($id = null, $nombreCompleto = null, $rol = null, $imagen = null, $esHabilitado = null, $anoNacimiento = null, $sexo = null,$correoElectronico=null, $nombreUsuario = null, $contrasena = null, $puntaje = null, $localidadId = null)
    {
        $this->id = $id;
        $this->nombreCompleto = $nombreCompleto;
        $this->rol = $rol;
        $this->imagen = $imagen;
        $this->esHabilitado = $esHabilitado;
        $this->anoNacimiento = $anoNacimiento;
        $this->sexo = $sexo;
        $this->correoElectronico = $correoElectronico;
        $this->nombreUsuario = $nombreUsuario;
        $this->contrasena = $contrasena;
        $this->puntaje = $puntaje;
        $this->localidadId = $localidadId;
    }
    // Métodos Setter
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombreCompleto($nombreCompleto)
    {
        $this->nombreCompleto = $nombreCompleto;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function setEsHabilitado($esHabilitado)
    {
        $this->esHabilitado = $esHabilitado;
    }

    public function setAnoNacimiento($anoNacimiento)
    {
        $this->anoNacimiento = $anoNacimiento;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }
    public function setCorreoElectronico($correoElectronico){
        $this->correoElectronico = $correoElectronico;
    }
    public function setNombreUsuario($nombreUsuario)
    {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
    }

    public function setPuntaje($puntaje)
    {
        $this->puntaje = $puntaje;
    }

    public function setLocalidadId($localidadId)
    {
        $this->localidadId = $localidadId;
    }

    // Métodos Getter
    public function getId()
    {
        return $this->id;
    }

    public function getNombreCompleto()
    {
        return $this->nombreCompleto;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function getImagen()
    {
        return $this->imagen;
    }

    public function getEsHabilitado()
    {
        return $this->esHabilitado;
    }

    public function getAnoNacimiento()
    {
        return $this->anoNacimiento;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function getCorreoElectronico(){
        return $this->correoElectronico;
    }

    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    public function getContrasena()
    {
        return $this->contrasena;
    }

    public function getPuntaje()
    {
        return $this->puntaje;
    }

    public function getLocalidadId()
    {
        return $this->localidadId;
    }

}

?>