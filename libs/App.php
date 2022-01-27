<?php
require_once "controllers/errores/errorControlador.php";
require_once "controllers/errores/errorMetodo.php";
require_once "libs/controller.php";
require_once "libs/view.php";
require_once "libs/model.php";
class App
{
    function __construct()
    {
        $datos = $this->limpiarUrl($_GET['url']);
        $nombreControlador = $datos[0];
        $archivoController = "controllers/$nombreControlador.php";
        #si el archivo no existe nos carga la pantalla de error    
        if (file_exists($archivoController)) {
            require_once $archivoController;
            if ($nombreMetodo = (isset($datos[1])) ? $datos[1] : false) {
                    $controlador = new $datos[0];
                    if(method_exists($controlador, $nombreMetodo)){
                        $controlador->{$nombreMetodo}();
                    }else{
                        $errorMetodo= new ErrorMetodo();
                    }
            } else {
                $controlador = new $datos[0];
            }
        } else {
            $error = new ErrorControlador();
        }
    }
    function limpiarUrl($cadena)
    {
        $datos = rtrim($cadena);
        $datos = explode('/', $datos);
        return $datos;
    }
}
