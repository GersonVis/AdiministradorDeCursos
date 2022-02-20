<?php

class Instructor extends Controller{
    function __construct()
    {
        parent::__construct();
    }
    function Renderizar($vista){
        $this->view->instructores=$this->modelo->todos();
        $this->view->columnas=$this->modelo->columnas();
        unset($this->view->columnas[0]);
        $this->view->Renderizar("$vista");
    }
    function informacionPorUrl($posicion){
        $informacion=$this->modelo->obtenerInformacion($posicion);
        $informacionArray=array();
        while($dato=mysqli_fetch_assoc($informacion)){
            $informacionArray[]=$dato;
        }
        echo json_encode($informacionArray);
    }
    function todos(){
        $datos=$this->modelo->todos();
        $arrayDatos=array();
        while($dato=mysqli_fetch_assoc($datos)){
            $arrayDatos[]=$dato;
        }
        echo json_encode($arrayDatos);
    }
    function eliminar(){
        $respuesta=$this->modelo->eliminar($_POST['id']);
        if(!$respuesta){
            echo $respuesta->error;
            http_response_code(404);
            exit();
        }
        $informacion=$this->modelo->obtenerInformacion($_POST['id']);
        if($informacion->num_rows()!=0){
            http_response_code(404);
            exit();
        }
    }
    function columnas(){
        echo $this->modelo->columnasJSON();
    }
    function crear(){
        $instructor=array();
        $datos['rfc']=$_POST['rfc']; 
        $datos['psw']=$_POST['psw'];
        $datos['nombre']=$_POST['nombre'];
        $datos['apellidoPaterno']=$_POST['apellidoPaterno'];
        $datos['apellidoMaterno']=$_POST['apellidoMaterno'];
        $datos['telefono']=$_POST['telefono'];
        $datos['sexo']=$_POST['sexo'];
        $datos['correo']=$_POST['correo'];
        $datos['domicilio']=$_POST['domicilio'];
        if(!$this->modelo->crear($datos)){
            http_response_code(404);
        }
        echo "creado correctamente";
    }
    function actualizar(){
        $arrayDatos=array();
        $arrayDatos['id']=$_POST['id'];
        $arrayDatos['columna']=$_POST['columna'];
        $arrayDatos['nuevo']=$_POST['nuevo'];
        if(!$this->modelo->actualizar($arrayDatos)){
            http_response_code(404);
            echo "no se pudo actualizar";
            exit();
        }
        echo "actualizado correctamente";
    }

}
?>