<?php
require_once "config/configuraciones.php";
require_once "libs/database.php";
require_once "libs/controller.php";
require_once "libs/view.php";
require_once "libs/model.php";
require_once "controllers/errores/errorControlador.php";
require_once "controllers/errores/errorMetodo.php";

class App
{
    function __construct()
    {
        $datos = $this->limpiarUrl();
    #    echo "   datos: ".var_dump($datos)."  ".$datos[0]."  d";
        $nombreControlador = $datos[0];
        $archivoController = "controllers/$nombreControlador.php";
        #si el archivo no existe nos carga la pantalla de error    
        if (file_exists($archivoController)) {
            require_once $archivoController;
            if ($nombreMetodo = (isset($datos[1])) ? $datos[1] : false) {
                $controlador = new $datos[0];
                if (method_exists($controlador, $nombreMetodo)) {
                    $controlador->CargarModelo($datos[0]);
                    $controlador->{$nombreMetodo}();
                } else {
                    $errorMetodo = new ErrorMetodo();
                }
            } else {
                $controlador = new $datos[0];
                $controlador->CargarModelo($datos[0]);
                $controlador->Renderizar($datos[0].'/index');
            }
        } else {
            $error = new ErrorControlador();
        }
    }
    function limpiarUrl()
    {
        if (!isset($_GET['url'])) {
            return array(0=>"main");
        }
        $datos = rtrim($_GET['url']);
        $datos = explode('/', $datos);
        return $datos;
    }
}
