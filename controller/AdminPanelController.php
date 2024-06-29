<?php
include_once("model/PdfCreator.php");

class AdminPanelController
{

    private $presenter;
    private $adminModel;
    private $mainSettings;

    public function __construct($presenter, $adminModel, $mainSettings)
    {
        $this->presenter = $presenter;
        $this->adminModel = $adminModel;
        $this->mainSettings = $mainSettings;
    }


    public function get()
    {

        //Cantidades
        $totalUsuarios = $this->adminModel->getCountUsuarios()["cantidad_usuarios"];
        $cantidadUsuariosCreados = $this->adminModel->getCountUsuariosCreated()["cantidad_usuarios_nuevos"];
        $totalPartidas = $this->adminModel->getCountPartidas()["cantidad_partidas"];
        $cantidadPreguntas = $this->adminModel->getTotalPreguntas()["cantidad_preguntas"];
        $cantidadPreguntasCreadas = $this->adminModel->getCountPreguntasCreated()["cantidad_preguntas_creadas"];
        $ganancia = $this->adminModel->getGanancia()["ganancia"];
        $ganancia = ($ganancia == null) ? 0 : $ganancia;

        $usuariosRatio = $this->adminModel->getUsuariosAndHisRatio();
        $usuariosPorPais = $this->adminModel->getUsuariosPorPais();
        $usuariosPorSexo = $this->adminModel->getUsuariosPorSexo();
        $cantidadMenores = $this->adminModel->getUsuariosMenores()["cantidad"];
        $cantidadMedios = $this->adminModel->getUsuariosMedios()["cantidad"];
        $cantidadJubilados = $this->adminModel->getUsuariosJubilados()["cantidad"];

        $this->presenter->render("view/viewAdminPanel.mustache", [
            "totalUsuarios" => $totalUsuarios,
            "cantidadUsuariosCreados" => $cantidadUsuariosCreados,
            "totalPartidas" => $totalPartidas,
            "cantidadPreguntas" => $cantidadPreguntas,
            "cantidadPreguntasCreadas" => $cantidadPreguntasCreadas,
            "ganancia" => $ganancia,
            "usuariosRatio" => $usuariosRatio,
            "usuariosPorPais" => $usuariosPorPais,
            "usuariosPorSexo" => $usuariosPorSexo,
            "cantidadMenores" => $cantidadMenores,
            "cantidadMedios" => $cantidadMedios,
            "cantidadJubilados" => $cantidadJubilados,
            ...$this->mainSettings
        ]);
    }

    public function generatePDF()
    {
        //Cantidades
        $totalUsuarios = $this->adminModel->getCountUsuarios()["cantidad_usuarios"];
        $cantidadUsuariosCreados = $this->adminModel->getCountUsuariosCreated()["cantidad_usuarios_nuevos"];
        $totalPartidas = $this->adminModel->getCountPartidas()["cantidad_partidas"];
        $cantidadPreguntas = $this->adminModel->getTotalPreguntas()["cantidad_preguntas"];
        $cantidadPreguntasCreadas = $this->adminModel->getCountPreguntasCreated()["cantidad_preguntas_creadas"];
        $ganancia = $this->adminModel->getGanancia()["ganancia"];
        $ganancia = ($ganancia == null) ? 0 : $ganancia;

        $usuariosRatio = $this->adminModel->getUsuariosAndHisRatio();
        $usuariosPorPais = $this->adminModel->getUsuariosPorPais();
        $usuariosPorSexo = $this->adminModel->getUsuariosPorSexo();
        $cantidadMenores = $this->adminModel->getUsuariosMenores()["cantidad"];
        $cantidadMedios = $this->adminModel->getUsuariosMedios()["cantidad"];
        $cantidadJubilados = $this->adminModel->getUsuariosJubilados()["cantidad"];
        
        $pdfCreator= new PdfCreator();

        $html = $this->presenter->generateHtmlForPDF("view/viewReportePDF.mustache", [
            "totalUsuarios" => $totalUsuarios,
            "cantidadUsuariosCreados" => $cantidadUsuariosCreados,
            "totalPartidas" => $totalPartidas,
            "cantidadPreguntas" => $cantidadPreguntas,
            "cantidadPreguntasCreadas" => $cantidadPreguntasCreadas,
            "ganancia" => $ganancia,
            "usuariosRatio" => $usuariosRatio,
            "usuariosPorPais" => $usuariosPorPais,
            "usuariosPorSexo" => $usuariosPorSexo,
            "cantidadMenores" => $cantidadMenores,
            "cantidadMedios" => $cantidadMedios,
            "cantidadJubilados" => $cantidadJubilados,
            ...$this->mainSettings
        ]);
        $pdfCreator->create($html);
 
    }

    public function filter(){
        $fechaDesde = $_POST["desde"];
        $fechaHasta = $_POST["hasta"];
        
    }

}

?>