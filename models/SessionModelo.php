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
        //  echo var_dump($consulta);
        $retorno = array("nombre" => "", "clave" => "", "idEnlazado" => "", "grado" => "", "nuevo"=>"");
        if (count($consulta) != 0) {
            $registroUsuario = $consulta[0];
            
            $conexion = $this->bd->conectar();
            $usuario = $registroUsuario["id"]["valor"];
         /*   $sqlConsultaEliminarEnlaces = "UPDATE usuario set primeraVez=1 where id=$usuario";
            $respuesta = $this->bd->consulta($conexion, $sqlConsultaEliminarEnlaces);
*/

            // echo var_dump($registroUsuario);
            if ($registroUsuario["idRol"]['valor'] == "3") {
                //si es maestro revisa la cuenta enlazada del maestro no solo del usuario
                $sqlConsulta = "SELECT maestro.nombre, maestro.id FROM maestrocuenta inner join maestro ON maestrocuenta.idMaestro=maestro.id where maestrocuenta.idUsuario=$usuario;";
                $consulta = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
                //     echo $sqlConsulta;
                $registroMaestro = $consulta[0];
                //   echo var_dump($registroMaestro);
                $retorno["nombre"] = $registroMaestro['nombre']['valor'];
                $retorno["idEnlazado"] = $registroMaestro['id']['valor'];
            } else { //si no es un maestro registra los datos directamente
                $retorno["nombre"] = $registroUsuario['nombre']['valor'];
                $retorno["idEnlazado"] = $registroUsuario['id']['valor'];
            }
            $retorno["id"] = $registroUsuario['id']['valor'];
            $retorno["clave"] = $registroUsuario['clave']['valor'];
            $retorno["idRol"] = $registroUsuario['idRol']['valor'];
            $retorno["nuevo"] = $registroUsuario['primeraVez']['valor'];
            return $retorno;
        }
        return false;
    }
    function maestro($id){
        $sqlConsulta = "select * from maestro where id=$id";
        $conexion = $this->bd->conectar();
        $consulta = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
        return $consulta;
    }
}
