<?php

class CursoModelo extends Model
{
  function __construct()
  {
    parent::__construct();
  }
  function obtenerInformacion($posicion)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from curso where id='$posicion'";
    $resultado = $conexion->query($sqlConsulta);
    $datosColumna = $resultado->fetch_fields();
    $columnasAsociadas = array();
    foreach ($datosColumna as $valor) {
      $columnasAsociadas[$valor->name] = $this->tiposDeDato($valor->type);
    }

    $informacion = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $itemFabricado = array();
      foreach ($item as $etiqueta => $valor) {
        $itemFabricado[$etiqueta] = array("valor" => $valor, "tipo" => $columnasAsociadas[$etiqueta]);
      }
      $informacion[] = $itemFabricado;
    }
    return $informacion;
  }
  function tiposDeDato($valor)
  {
    switch ($valor) {
      case MYSQLI_TYPE_DECIMAL:
      case MYSQLI_TYPE_NEWDECIMAL:
      case MYSQLI_TYPE_FLOAT:
      case MYSQLI_TYPE_DOUBLE:
      case MYSQLI_TYPE_BIT:
      case MYSQLI_TYPE_TINY:
      case MYSQLI_TYPE_SHORT:
      case MYSQLI_TYPE_LONG:
      case MYSQLI_TYPE_LONGLONG:
      case MYSQLI_TYPE_INT24:
      case MYSQLI_TYPE_YEAR:
      case MYSQLI_TYPE_ENUM:
        return 'number';

      case MYSQLI_TYPE_TIMESTAMP:
      case MYSQLI_TYPE_DATE:
      case MYSQLI_TYPE_TIME:
      case MYSQLI_TYPE_DATETIME:
      case MYSQLI_TYPE_NEWDATE:
      case MYSQLI_TYPE_INTERVAL:
        return "date";
      case MYSQLI_TYPE_SET:
      case MYSQLI_TYPE_VAR_STRING:
      case MYSQLI_TYPE_STRING:
      case MYSQLI_TYPE_CHAR:
      case MYSQLI_TYPE_GEOMETRY:
      case MYSQLI_TYPE_TINY_BLOB:
      case MYSQLI_TYPE_MEDIUM_BLOB:
      case MYSQLI_TYPE_LONG_BLOB:
      case MYSQLI_TYPE_BLOB:
        return 'text';

      default:
        return 'text';
    }
  }


  function todos()
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "select * from curso";
    $resultado = $conexion->query($sqlConsulta);

    $datosColumna = $resultado->fetch_fields();
    $columnasAsociadas = array();
    foreach ($datosColumna as $valor) {
      $columnasAsociadas[$valor->name] = $this->tiposDeDato($valor->type);
    }
    $informacion = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $itemFabricado = array();
      foreach ($item as $etiqueta => $valor) {
        $itemFabricado[$etiqueta] = array("valor" => $valor, "tipo" => $columnasAsociadas[$etiqueta]);
      }
      $informacion[] = $itemFabricado;
    }
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
    if (!$consulta = $conexion->prepare("update curso set {$datos['columna']}=? where id=?")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("ss", $datos['nuevo'], $datos['id']);
    $consulta->execute();
    return true;
  }
  function buscar($valor, $condicionales)
  {
    $sqlConsulta = "select * from curso where ";
    $sqlCondicional = "";
    foreach ($condicionales as $etiqueta => $valorArray) {
      if ($valorArray == "1") {
        $sqlCondicional .= "$etiqueta like '$valor%' or ";
      }
    }
    $informacion = array();
    if ($sqlCondicional != "") {
      $sqlCondicional = substr($sqlCondicional, 0, -4); //removemos la parte or que queda
      $sqlConsulta = $sqlConsulta . $sqlCondicional;

      $conexion = $this->bd->conectar();
      $informacion=$this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    }
    return $informacion; //si no se recivio ninguna condición se retorna un array vacio
  }
  function instructoresEnlazados($id){
      $sqlConsulta="SELECT  intr.id, intr.nombre, intr.rfc FROM impartio,instructor as intr WHERE impartio.idCurso=$id and impartio.idInstructor=intr.id;";
      $conexion = $this->bd->conectar();
      $informacion=$this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
      return $informacion;
  }
}
