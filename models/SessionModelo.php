<?php
class SessionModelo extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function usuario($usuario, $clave)
    {
        $sqlConsulta = "select * from usuario where usuario.nombre='$usuario' and usuario.clave='$clave';";
        $conexion = $this->bd->conectar();
        $consulta = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
        $retorno=array("nombre"=>"", "clave"=>"", "idEnlazado"=>"", "grado"=>"");
        if (count($consulta) != 0) {
            $registroUsuario = $consulta[0];
            if ($registroUsuario["idRol"]['valor'] == "3") {
                $usuario=$registroUsuario["id"]["valor"];
                $sqlConsulta = "SELECT maestro.nombre, maestro.id FROM maestrocuenta inner join maestro ON maestrocuenta.idMaestro=maestro.id where maestrocuenta.idUsuario=$usuario;";
                $consulta = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
                $registroMaestro=$consulta[0];
            //    echo var_dump($registroMaestro);
                $retorno["nombre"]=$registroMaestro['nombre']['valor'];
                $retorno["clave"]=$registroUsuario['clave']['valor'];
                $retorno["idEnlazado"]=$registroMaestro['id']['valor'];
                $retorno["grado"]=$registroUsuario['idRol']['valor'];
            } else {
                $retorno["nombre"]=$registroUsuario['nombre']['valor'];
                $retorno["clave"]=$registroUsuario['clave']['valor'];
                $retorno["grado"]=$registroUsuario['idRol']['valor'];
                $retorno["idEnlazado"] = "-1";
            }
            return $retorno;
        }
        return false;
    }
}
