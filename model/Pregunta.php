<?php
class Pregunta
{
    private $id;
    private $punto;
    private $esValido;
    private $descripcion;
    private $categoriaId;

    // Constructor
    public function __construct($id=null, $punto=null, $esValido=null, $descripcion=null, $categoriaId=null)
    {
        $this->id = $id;
        $this->punto = $punto;
        $this->esValido = $esValido;
        $this->descripcion = $descripcion;
        $this->categoriaId = $categoriaId;
    }

    // Métodos Setter
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setPunto($punto)
    {
        $this->punto = $punto;
    }

    public function setEsValido($esValido)
    {
        $this->esValido = $esValido;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function setCategoriaId($categoriaId)
    {
        $this->categoriaId = $categoriaId;
    }

    // Métodos Getter
    public function getId()
    {
        return $this->id;
    }

    public function getPunto()
    {
        return $this->punto;
    }

    public function getEsValido()
    {
        return $this->esValido;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getCategoriaId()
    {
        return $this->categoriaId;
    }
}

?>