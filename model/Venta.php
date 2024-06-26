<?php
class Venta {
    private $id;
    private $cantidad;
    private $precio;
    private $usuario_id;
    
    // Constructor con valores por defecto null
    public function __construct($id = null, $cantidad = null, $precio = null, $usuario_id = null) {
        $this->id = $id;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->usuario_id = $usuario_id;
    }
    
    // Getters y setters (métodos de acceso)
    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        $this->id = $id;
    }
    
    public function getCantidad() {
        return $this->cantidad;
    }
    
    public function setCantidad($cantidad) {
        $this->cantidad = $cantidad;
    }
    
    public function getPrecio() {
        return $this->precio;
    }
    
    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    
    public function getUsuarioId() {
        return $this->usuario_id;
    }
    
    public function setUsuarioId($usuario_id) {
        $this->usuario_id = $usuario_id;
    }
}
?>