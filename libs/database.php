<?php
class Database
{
    private $host;
    private $db;
    private $user;
    private $password;
    private $charset;
    public function __construct()
    {
        $this->host=constant('HOST');
        $this->db=constant('DB');
        $this->user=constant('USER');
        $this->password=constant('PASSWORD');
        $this->charset=constant('CHARSET');
    }
    function conectar(){
        $conexion = new mysqli('localhost', $this->user, $this->password, $this->db);
        if($conexion->connect_errno){
            exit();
            return '';
        }
        return $conexion;
    }
    function consulta($conexion, $sqlConsulta){
        $respuesta=$conexion->query($sqlConsulta);
        return $respuesta;
    }
}
