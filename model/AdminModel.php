<?php
class AdminModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }


    /*CANTIDADES */
    public function getCountUsuarios()
    {
        return $this->database->query("select count(*) as cantidad_usuarios from usuario");
    }

    public function getCountUsuariosCreated()
    {
        return $this->database->query("select count(*) as cantidad_usuarios_nuevos from usuario where fechaCreacion = curdate()");
    }

    public function getCountPartidas()
    {
        return $this->database->query("select count(*) as cantidad_partidas from partida");
    }

    public function getTotalPreguntas()
    {
        return $this->database->query("select count(*) as cantidad_preguntas from pregunta");
    }

    public function getCountPreguntasCreated()
    {
        return $this->database->query("select count(*) as cantidad_preguntas_creadas from pregunta where fechaCreacion = curdate()");
    }

    public function getGanancia()
    {
        return $this->database->query("select sum(precio) as ganancia from venta");
    }


    /*Consultas para los graficos */

    public function getUsuariosAndHisRatio()
    {
        return $this->database->query("select u.nombrerUsuario , u.ratio from usuario u where nivel != 'INDEFINIDO'");
    }

    public function getUsuariosPorPais()
    {
        return $this->database->query("select pais, count(*) as cantidad_usuarios_pais from usuario where nivel != 'INDEFINIDO' GROUP BY pais");
    }

    public function getUsuariosPorSexo()
    {
        return $this->database->query("select sexo, count(*) as cantidad_usuarios_sexo from usuario where nivel != 'INDEFINIDO' group by sexo");
    }

    public function getUsuariosMenores()
    {
        return $this->database->query("SELECT count(*) as cantidad FROM usuario
            where TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) < 18");
    }
    public function getUsuariosMedios(){
        return $this->database->query("SELECT count(*) as cantidad FROM usuario
            where TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) between 18 and 60;");
    }
    public function getUsuariosJubilados()
    {
        return $this->database->query("SELECT count(*) as cantidad FROM usuario
                where TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) > 60");
    }
}
?>