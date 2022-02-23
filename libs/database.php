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
    function tiposDeDatoConsulta($conexion, $sqlConsulta){
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
}
