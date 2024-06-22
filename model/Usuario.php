<?php
class Usuario
{
    private $id;
    private $nombreCompleto;
    private $rol;
    private $imagen;
    private $esHabilitado;
    private $fechaNacimiento;
    private $sexo;
    private $correoElectronico;
    private $nombreUsuario;
    private $contrasena;
    private $pais;
    private $ciudad;

    private $cantidad_dadas;
    private $cantidad_acertadas;
    private $ratio;
    private $nivel;
    public function __construct($id = null, $nombreCompleto = null, $rol = null, $imagen = null, $esHabilitado = null, $fechaNacimiento = null, $sexo = null, $correoElectronico = null, $nombreUsuario = null, $contrasena = null, $pais = null, $ciudad = null, $cantidad_dadas=null, $cantidad_acertadas=null, $ratio = null, $nivel = null)
    {
        $this->id = $id;
        $this->nombreCompleto = $nombreCompleto;
        $this->rol = $rol;
        $this->imagen = $imagen;
        $this->esHabilitado = $esHabilitado;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->sexo = $sexo;
        $this->correoElectronico = $correoElectronico;
        $this->nombreUsuario = $nombreUsuario;
        $this->contrasena = $contrasena;
        $this->pais = $pais;
        $this->ciudad = $ciudad;
        $this->cantidad_dadas = $cantidad_dadas;
        $this->cantidad_acertadas = $cantidad_acertadas;
        $this->ratio = $ratio;
        $this->nivel = $nivel;
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

    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    }
    public function setCorreoElectronico($correoElectronico)
    {
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

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function getSexo()
    {
        return $this->sexo;
    }

    public function getCorreoElectronico()
    {
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

    // Getter para $pais
    public function getPais()
    {
        return $this->pais;
    }

    // Setter para $pais
    public function setPais($pais)
    {
        $this->pais = $pais;
    }

    // Getter para $ciudad
    public function getCiudad()
    {
        return $this->ciudad;
    }

    // Setter para $ciudad
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;
    }


      // Getter and Setter for cantidad_dadas
      public function getCantidadDadas() {
        return $this->cantidad_dadas;
    }

    public function setCantidadDadas($cantidad_dadas) {
        $this->cantidad_dadas = $cantidad_dadas;
    }

    // Getter and Setter for cantidad_acertadas
    public function getCantidadAcertadas() {
        return $this->cantidad_acertadas;
    }

    public function setCantidadAcertadas($cantidad_acertadas) {
        $this->cantidad_acertadas = $cantidad_acertadas;
    }

    // Getter and Setter for ratio
    public function getRatio() {
        return $this->ratio;
    }

    private function setRatio($ratio) {
        $this->ratio = $ratio;
    }

    // Getter and Setter for nivel
    public function getNivel() {
        return $this->nivel;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

} ?>