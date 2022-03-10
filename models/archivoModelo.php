<?php
class ArchivoModelo extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function Renderizar($vista)
    {
        $this->view->Renderizar("archivo/index");
        exit();
    }
    function registrarCarga($ruta, $descripcion, $nombre)
    {
        $conexion = $this->bd->conectar();
        if (!$consulta = $conexion->prepare("insert into archivo values(null, ?, ?, ?)")) {
            echo "error";
            return false;
        }
        $consulta->bind_param("sss", $ruta, $descripcion, $nombre);
        //$idInsertado=$this->mysqli->insert_id;
        $consulta->execute();
        return true;
    }
    function todos()
    {
        $conexion = $this->bd->conectar();
        $sqlConsulta = "select * from archivo";
        $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
        return $informacion;
    }
    function obtenerInformacion($posicion)
    {
      $conexion = $this->bd->conectar();
      $sqlConsulta = "select * from archivo where id='$posicion'";
      $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
      unset($informacion[0]['id']);
      unset($informacion[0]['ruta']);
      unset($informacion[0]['nombre']);
      return $informacion;

    }
    function actualizar($datos)
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("update curso set {$datos['columna']}=? where id=?")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("ss", $datos['nuevo'], $datos['id']);
    $consulta->execute();
    return true;
  }
}
