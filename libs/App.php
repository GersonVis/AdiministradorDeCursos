<?php
require_once "controllers/ErrorControlador.php";
require_once "controllers/ErrorMetodo.php";
class App
{
    function __construct()
    {
        $datos=$this->limpiarUrl($_GET['url']);
        $nombreControlador=$datos[0];
        $archivoController = "controllers/$nombreControlador.php";
        #si el archivo no existe nos carga la pantalla de error
        if (file_exists($archivoController)) {
            require_once $archivoController;
            $controlador = new $datos[0];
            if ($nombreMetodo=(isset($datos[1]))?$datos[1]:false) {
                $controlador->{$nombreMetodo}();
            } else {
                $errorMetodo = new ErrorMetodo();
            }
        } else {
            $error = new ErrorControlador();
        }
    }
  function limpiarUrl($cadena){
    $datos = rtrim($cadena);
    $datos = explode('/', $datos);
    return $datos;
  }
}
