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
    public function getUsuariosAndHisRatioByFilter($desde, $hasta)
    {
    
        return $this->database->query("select u.nombrerUsuario , u.ratio from usuario u where nivel != 'INDEFINIDO' and fechaCreacion between '$desde' and '$hasta'");
    }

    public function getUsuariosPorPais()
      {
        return $this->database->query("select pais, count(*) as cantidad_usuarios_pais from usuario where nivel != 'INDEFINIDO' GROUP BY pais");
    }

    public function getUsuariosPorPaisByFilter($desde, $hasta){
        return $this->database->query("select pais, count(*) as cantidad_usuarios_pais from usuario where nivel != 'INDEFINIDO' and fechaCreacion between '$desde' and '$hasta' GROUP BY pais");

    }

    public function getUsuariosPorSexo()
    {
        return $this->database->query("select sexo, count(*) as cantidad_usuarios_sexo from usuario where nivel != 'INDEFINIDO' group by sexo");
    }

    public function getUsuarioPorSexoByFilter($desde, $hasta){
        return $this->database->query("select sexo, count(*) as cantidad_usuarios_sexo from usuario where nivel != 'INDEFINIDO' and fechaCreacion between '$desde' and '$hasta' group by sexo");
    }

    public function getUsuariosMenores()
    {
        return $this->database->query("SELECT count(*) as cantidad FROM usuario
            where TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) < 18");
    }
    public function getUsuariosMenoresByFilter($desde, $hasta){
        return $this->database->query("SELECT count(*) as cantidad FROM usuario
            where TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) < 18 and fechaCreacion between '$desde' and '$hasta'");
    
    }

    public function getUsuariosMedios(){
        return $this->database->query("SELECT count(*) as cantidad FROM usuario
            where TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) between 18 and 60;");
    }
    public function getUsuarioMediosByFilter($desde, $hasta){
        return $this->database->query("SELECT count(*) as cantidad FROM usuario
            where TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) between 18 and 60 and fechaCreacion between '$desde' and '$hasta'");
    }

    public function getUsuariosJubilados()
    {
        return $this->database->query("SELECT count(*) as cantidad FROM usuario
                where TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) > 60");
    }

    public function getUsuarioJubiladosByFilter($desde,$hasta){
        return $this->database->query("SELECT count(*) as cantidad FROM usuario
                where TIMESTAMPDIFF(YEAR, fechaNacimiento, CURDATE()) > 60 and fechaCreacion between '$desde' and '$hasta'");
    }
}
?>