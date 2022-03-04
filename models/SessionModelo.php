<?php
class SessionModelo extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function usuario($usuario, $clave)
    {
        $sqlConsulta = "select * from usuario inner join rol on usuario.idRol=rol.id where usuario.nombre='$usuario' and usuario.clave='$clave';";
        $conexion = $this->bd->conectar();
        $consulta = $this->bd->consulta($conexion, $sqlConsulta);
        if ($consulta->num_rows != 0) {
            return $consulta;
        }
        return false;
    }
}
