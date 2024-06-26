<?php 

    class VentaModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }
        
        public function insertNewVenta($venta){
            $this->database->execute("INSERT INTO venta (id,cantidad,precio,usuario_id) VALUES ('".$venta->getId()."','".$venta->getCantidad()."','".$venta->getPrecio()."','".$venta->getUsuarioId()."')");
        }
    
    }
?>