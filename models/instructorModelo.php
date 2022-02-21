<?php
class InstructorModelo extends Model
{
  function __construct()
  {
    parent::__construct();
  }
  function obtenerInformacion($posicion)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from instructor where id='$posicion'";
    $informacion = $conexion->query($sqlConsulta);
    return  $informacion;
  }

  function todos()
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from instructor";
    $informacion = $conexion->query($sqlConsulta);
    return $informacion;
  }


  function eliminar($id)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "delete from instructor where id=$id";
    $respuesta = $this->bd->consulta($conexion, $sqlConsulta);
    return $respuesta;
  }
  function columnas()
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM instructor");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[] = $item['Field'];
    }
    return $etiquetas;
  }

  function columnasJSON()
  {
    $con = $this->modelo->bd->conectar();
    $resultado = $this->modelo->bd->consulta($con, "SHOW COLUMNS FROM instructor");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[] = $item['Field'];
    }
    echo json_encode($etiquetas);
  }
  function crear($datos)
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("INSERT INTO instructor VALUES (NULL, ?,?,?,?,?,?,?,?,?);")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("sssssssss", $datos['rfc'], $datos['psw'], $datos['nombre'], $datos['apellidoPaterno'], $_POST['apellidoMaterno'], $_POST['telefono'], $_POST['sexo'], $_POST['correo'], $_POST['domicilio']);
    $consulta->execute();
    return true;
  }
  function actualizar($datos)
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("update instructor set {$datos['columna']}=? where id=?")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("ss", $datos['nuevo'], $datos['id']);
    $consulta->execute();
    return true;
  }
  function buscar($valor, $condicionales)
  {
    $sqlConsulta = "select * from instructor where ";
    $sqlCondicional="";
    foreach ($condicionales as $etiqueta => $valorArray) {
      if ($valorArray == "1") {
        $sqlCondicional .= "$etiqueta like '$valor%' or ";
      }
    }
    $etiquetas=array();
    if($sqlCondicional!=""){
      $sqlCondicional = substr($sqlCondicional, 0, -4);//removemos la parte or que queda
      $sqlConsulta=$sqlConsulta.$sqlCondicional;
      $con = $this->bd->conectar();
      $resultado = $this->bd->consulta($con, $sqlConsulta);
      $etiquetas = array();
      while ($item = mysqli_fetch_assoc($resultado)) {
        $etiquetas[] = $item;
      }
    }
    return $etiquetas;//si no se recivio ninguna condición se retorna un array vacio
  }
}
