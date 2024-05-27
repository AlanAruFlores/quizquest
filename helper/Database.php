<?php
    class Database{

        private $conexion;
        public function __construct($host="localhost:3306", $user="root", $password="", $dbname="pokedex_db"){
            $this->conexion = mysqli_connect($host,$user,$password,$dbname);
        }

        public function query($sql){
            $result = mysqli_query($this->conexion, $sql);
            if(mysqli_num_rows($result) == 1)
                return mysqli_fetch_assoc($result);
            return mysqli_fetch_all($result,MYSQLI_ASSOC);
        }        

        public function execute($sql){
            mysqli_query($this->conexion, $sql);
        }

        public function __destruct(){
            mysqli_close($this->conexion);
        }

    }
?>