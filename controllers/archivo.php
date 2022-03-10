<?php
class Archivo extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->view->nombre = "archivo";
    }
    function informacionPorUrl($posicion)
    {
        $datos = $this->modelo->obtenerInformacion($posicion);
        echo json_encode($datos);
    }
    function todos()
    {
        $datos = $this->modelo->todos();

        echo json_encode($datos);
    }
    function subirArchivo()
    {
        $archivo = $_FILES["archivo"];
        $rutaLocal = "public/documentacion/";
        $nombre=basename($archivo["name"]);
        $ruta = $rutaLocal . $nombre;
        $descripcion = $_POST['descripcion'];
        if (move_uploaded_file($archivo['tmp_name'], $ruta)) {

            if ($this->modelo->registrarCarga($ruta, $descripcion, $nombre)) {
                echo "exito";
                exit();
            }
        }
        echo "fallo";
        http_response_code(404);
    }
    function actualizar()
    {
        $arrayDatos = array();
        $arrayDatos['id'] = $_POST['id'];
        $arrayDatos['columna'] = $_POST['columna'];
        $arrayDatos['nuevo'] = $_POST['nuevo'];
        if (!$this->modelo->actualizar($arrayDatos)) {
            http_response_code(404);
            echo " no se pudo actualizar";
            exit();
        }
        echo "actualizado correctamente";
    }
}
