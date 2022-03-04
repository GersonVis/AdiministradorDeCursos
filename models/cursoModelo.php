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
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    unset($informacion[0]['id']);
    return $informacion;
   /* $resultado = $conexion->query($sqlConsulta);
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
    }*/
    //return $informacion;
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
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return $informacion;
  }


  function eliminar($id)
  {
    $conexion = $this->bd->conectar();

    $sqlConsultaEliminarEnlaces = "delete from impartio where idCurso=$id;";
    $respuesta = $this->bd->consulta($conexion, $sqlConsultaEliminarEnlaces);
    $sqlConsulta = "delete from curso where id=$id";
    $respuesta = $this->bd->consulta($conexion, $sqlConsulta);
    return $respuesta;
  }
  function columnas() ///regresa los datos de las columnas que contiene la tabla
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM curso");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[] = $item['Field'];
    }
    return $etiquetas;
  }

  function columnasJSON()
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM curso");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[] = $item['Field'];
    }
    unset($etiquetas['id']);
    return json_encode($etiquetas);
  }



  function crear($datos, $idsInstructores) //se crea el curso y se enlazan los ids de instructores en la tabla de impartio
  {
    $conexion = $this->bd->conectar();
    if (!$consulta = $conexion->prepare("INSERT INTO curso VALUES (NULL, ?,?,?,?,?,?,?,?);")) {
      echo "error";
      return false;
    }
    $consulta->bind_param("ssssssss", $datos['claveCurso'], $datos['fechaInicial'], $datos['fechaFinal'], $datos['horas'], $datos['cupo'], $datos['nombreCurso'], $datos['lugar'], $datos['horario']);
    //$idInsertado=$this->mysqli->insert_id;
    $consulta->execute();
    $idInsertado = $consulta->insert_id;
    foreach ($idsInstructores as $idInstructor => $valor) {
      $this->bd->consulta($conexion, "insert impartio valueS(NULL,  '$idInsertado', '$idInstructor')");
    }
    $conexion->close();
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
      $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    }
    return $informacion; //si no se recivio ninguna condición se retorna un array vacio
  }
  function instructoresEnlazados($id)
  {
    $sqlConsulta = "SELECT  intr.id, intr.nombre, intr.rfc FROM impartio,instructor as intr WHERE impartio.idCurso=$id and impartio.idInstructor=intr.id;";
    $conexion = $this->bd->conectar();
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);
    return $informacion;
  }
  function convertirdorIipo($entrada)
  {
    $tipoEnBruto = substr($entrada, 0, strpos($entrada, '('));
    $tipoEnBruto = $tipoEnBruto == "" ? $entrada : $tipoEnBruto;
    switch ($tipoEnBruto) {
      case "bigint":
      case "int":
        return "number";
        break;
      case "date":
        return "date";
        break;
      case "varchar":
        return "text";
        break;
      default:
        return "text";
        break;
    }
  }
  function columnasTipo()
  {
    $con = $this->bd->conectar();
    $resultado = $this->bd->consulta($con, "SHOW COLUMNS FROM curso");
    $etiquetas = array();
    while ($item = mysqli_fetch_assoc($resultado)) {
      $etiquetas[$item['Field']] = array("valor" => "",  "tipo" => $this->convertirdorIipo($item['Type']));
    }
    unset($etiquetas['id']);
    return $etiquetas;
  }
  function enlazar($idCurso, $idsInstructores)
  {
    $con = $this->bd->conectar();
    echo var_dump($idsInstructores);
    foreach ($idsInstructores as $idInstructor => $valor) {
      $resultado = $this->bd->consulta($con, "insert into impartio values(null, $idCurso, $idInstructor)");
      echo $idInstructor;
      //printf("%s %s\n", $idInstructor, $idsInstructores);
    }
    return true;
  }


  function instructoresDisponibles($idCurso)
  {
    /*obtenemos los ids de los instructores que tiene el curso
  luego solicitamos los instructores que no tengan ese id*/
    $conexion = $this->bd->conectar();
    $respuesta = $this->bd->consulta($conexion, "SELECT instructor.id FROM instructor INNER JOIN impartio
    ON impartio.idInstructor=instructor.id where impartio.idCurso=$idCurso");
    $idsRechazados = "";
    $sqlConsulta="";
    
    if ($respuesta->num_rows != 0) {
      while ($idEnlazado = mysqli_fetch_assoc($respuesta)) {
        $idsRechazados .= $idEnlazado['id'] . ", ";
      }
      $idsRechazados = substr($idsRechazados, 0, -2);
      $sqlConsulta="select * from instructor where id not in($idsRechazados);";
    }else{
      $sqlConsulta = "select * from instructor";
    }
    
   // echo $sqlConsulta;
    $informacion = $this->bd->tiposDeDatoConsulta($conexion, $sqlConsulta);

    return $informacion;
  }
  function desenlazar($idCurso, $idInstructor)
  {
    $conexion = $this->bd->conectar();
    $sqlConsulta = "delete from impartio where idCurso=$idCurso and idInstructor=$idInstructor";
    $resultado = $this->bd->consulta($conexion, $sqlConsulta);
    return $resultado;
  }
}
