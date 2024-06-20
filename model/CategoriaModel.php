<?php 
    class CategoriaModel{
        private $database;

        public function __construct($database){
            $this->database = $database;
        }

        public function getAllCategorias(){
            return $this->database->query("SELECT * FROM categoria");
        }

        public function getAllCategoriasBasedPreguntaCategoria($pregunta){
            $categoriasAux = self::getAllCategorias();
            $categorias = [];
            foreach ($categoriasAux as $categoria) {
                if($categoria["nombre"] == $pregunta["descripcion_categoria"]) 
                    $categoria += ["esSuCategoria" => true];
                else
                    $categoria += ["esSuCategoria" => false];
            
                $categorias[] = $categoria; 
            }

            return $categorias;
        }


    }

?>