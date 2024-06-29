<?php
    class AdminPanelController{

        private $presenter;
        private $adminModel;
        private $mainSettings;
        
        public function __construct($presenter,$adminModel, $mainSettings){
            $this->presenter = $presenter;
            $this->adminModel = $adminModel;
            $this->mainSettings = $mainSettings;
        }   


        public function get(){
  
            //Cantidades
            $totalUsuarios=$this->adminModel->getCountUsuarios()["cantidad_usuarios"];
            $cantidadUsuariosCreados = $this->adminModel->getCountUsuariosCreated()["cantidad_usuarios_nuevos"];
            $totalPartidas = $this->adminModel->getCountPartidas()["cantidad_partidas"];
            $cantidadPreguntas = $this->adminModel->getTotalPreguntas()["cantidad_preguntas"];
            $cantidadPreguntasCreadas = $this->adminModel->getCountPreguntasCreated()["cantidad_preguntas_creadas"];
            $ganancia = $this->adminModel->getGanancia()["ganancia"];
            $ganancia = ($ganancia == null) ? 0 : $ganancia;

            $usuariosRatio = $this->adminModel->getUsuariosAndHisRatio();

            $this->presenter->render("view/viewAdminPanel.mustache", [
                "totalUsuarios"=>$totalUsuarios,
                "cantidadUsuariosCreados"=>$cantidadUsuariosCreados,
                "totalPartidas"=>$totalPartidas,
                "cantidadPreguntas"=>$cantidadPreguntas,
                "cantidadPreguntasCreadas"=>$cantidadPreguntasCreadas,
                "ganancia"=>$ganancia,
                "usuariosRatio"=>$usuariosRatio,
                ...$this->mainSettings
            ]);
        }

    }

?>