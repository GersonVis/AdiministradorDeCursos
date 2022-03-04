<?php

class Curso extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->view->nombre="curso";//declarar el nombre del controlador en el que estamos, se usa en las vistas
    }
    function Renderizar($vista)
    {
        $this->view->instructores = $this->modelo->todos();
        $this->view->columnas = $this->modelo->columnas();
        unset($this->view->columnas[0]);
        $this->view->Renderizar("$vista");
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
    function eliminar()
    {
        $respuesta = $this->modelo->eliminar($_POST['id']);
        if (!$respuesta) {
            echo $respuesta->error;
            http_response_code(404);
            exit();
        }
        $informacion = $this->modelo->obtenerInformacion($_POST['id']);
        if ($informacion->num_rows() != 0) {
            http_response_code(404);
            exit();
        }
    }
    function columnas()
    {
        echo $this->modelo->columnasJSON();
    }
    function crear()
    {
        $instructor = array();
        $datos['claveCurso'] = $_POST['claveCurso'];
        $datos['fechaInicial'] = $_POST['fechaInicial'];
        $datos['fechaFinal'] = $_POST['fechaFinal'];
        $datos['horas'] = $_POST['horas'];
        $datos['cupo'] = $_POST['cupo'];
        $datos['nombreCurso'] = $_POST['nombreCurso'];
        $datos['lugar'] = $_POST['lugar'];
        $datos['horario'] = $_POST['horario'];

        $instructoresEnlazados = json_decode($_POST['instructores']);
        if (!$this->modelo->crear($datos, $instructoresEnlazados)) {
            http_response_code(404);
        }
        echo "creado correctamente";
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
    function busqueda()
    {
        $valor = $_POST['valor'];
        $datos = $_POST;
        unset($datos['valor']);

        $ar = fopen("errores.txt", "w");
        fwrite($ar, "escribiendo");
        $v = var_export($_POST, true);
        fwrite($ar, $v);
        $resultadoConsulta = array();
        if (count($datos) != 0) {
            $resultadoConsulta = $this->modelo->buscar($valor, $datos);
        }
        echo json_encode($resultadoConsulta);
    }
    function instructoresEnlazados()
    {
        $idCurso = $_POST['curso'];
        $respuesta = array("datos" => $idCurso);
        $respuesta = $this->modelo->instructoresEnlazados($idCurso);
        echo json_encode($respuesta);
    }
    function columnasTipo()
    {
        $respuesta = $this->modelo->columnasTipo();
        echo json_encode($respuesta);
    }
    function enlazar()
    {
        
        $idInstructores = json_decode($_POST['idsInstructores']);
        $idCurso = $_POST['idCurso'];
        $respuesta=$this->modelo->enlazar($idCurso, $idInstructores);
        
    }
    function instructoresDisponibles()
    {
        $idCurso = $_POST['idCurso'];
        $respuesta=$this->modelo->instructoresDisponibles($idCurso);
        echo json_encode($respuesta);
    }
    function desenlazar(){
        $idCurso=$_POST['idCurso'];
        $idInstructor=$_POST['idInstructor'];
        $respuesta=$this->modelo->desenlazar($idCurso, $idInstructor);
        if(!$respuesta){
            http_response_code(404);
            exit();
        }
    }
}
