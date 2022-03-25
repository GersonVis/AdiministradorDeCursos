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
        $propietario =$_SESSION['id'];
        //los tipos de archivo es para saber a que conjunto pertenece, los conjuntos disponibles
        //estan en la tabla conjuntoarchivo el id 1 es para conjunto libre
        $tipoArchivo = isset($_POST["tipo"])?$_POST["tipo"]:"1";
        $errores=0;
        foreach($_FILES as $identificador=>$archivo){
            $archivo = $archivo;
            $rutaLocal = $_SESSION["carpeta"];
            $nombre=basename($archivo["name"]);
            $ruta = $rutaLocal . $nombre;
            $descripcion = isset($_POST['descripcion'])?$_POST['descripcion']:"";
            if(!file_exists($ruta)){
                if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
                     if ($this->modelo->registrarCarga($ruta, $descripcion, $nombre, $propietario, $tipoArchivo)) {
                        continue;  
                       }
                   }
            }
            $errores++;
        }
        echo "han ocurrido ".$errores." Errores";
    }
    function liberacionCurso(){
      //Recive archivos por metodo post, luego los registra en la base de datos
      //conjunto es el apartado de archivos para la liberación, se puede consultar en conjuntoArchivo
        $cuenta=array('id'=>$_SESSION['id'],'idRol'=>"1");//el unico que tiene permisos para elimiar archivo es el administrador ver tabla permiso
        $idCurso=$_POST['idCurso'];
        $idConjunto=$_POST['idConjunto'];
        $errores=0;
        $this->modelo->registrarEstadoDelConjunto($idConjunto, $idCurso, $cuenta['id'], 1);
        foreach($_FILES as $identificador=>$archivo){
            //recorre todos los archivos enviados en el formulario y guarda un  registro en la base de datos
            //cada regsitro lleva el usuario que lo subio, nombre del archivo y ruta
            $archivo = $archivo;
            $rutaLocal = $_SESSION["carpeta"];
            $nombre=basename($archivo["name"]);
            $ruta = $rutaLocal . $nombre;
            $descripcion = isset($_POST['descripcion'])?$_POST['descripcion']:"";
            if(!file_exists($ruta)){
                if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
                     if ($this->modelo->registrarSolicitudLiberacion($ruta, $descripcion, $nombre, $cuenta, $idCurso, $idConjunto)) {
                        continue;  
                       }
                   }
            }
            $errores++;
        }
        echo "Han ocurrido ".$errores.($errores==1?" Error": " Errores"); 
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
    function eliminar()
    {
        $id=$_POST['id'];
        $datos = $this->modelo->obtenerInformacion($id);
        
        if(count($datos)>0){
            $archivo=$datos[0];
            $rutaArchivo=$archivo['ruta'];
            if(unlink($rutaArchivo['valor']) && $this->modelo->eliminar($id)){
                echo "Eliminado correctamente";
                exit();
            }
        }
        http_response_code(404);
    }
    private function informacionArchivos($usuario, $idCurso, $idConjunto, $idRol){
        $registroArchivos=$this->modelo->consultarArchivosGrupo($usuario, $idCurso, $idConjunto);
        foreach($registroArchivos as $etiqueta=>$datos){
             $idArchivo=$datos['id']['valor'];
             $permisos=$this->modelo->consultarPermiso($idArchivo, $idRol);
             $datos["permisoEliminar"]=array("valor"=>count($permisos)==true);
             $datos["permisoModificar"]=array("valor"=>($idRol)==1);
             $registroArchivos[$etiqueta]=$datos;
           
        }
        echo json_encode($registroArchivos);
        exit();
    }
    function registroArchivosSubidos(){
        $usuario=$_SESSION['id'];
        $idCurso=$_POST['idCurso'];
        $idConjunto=$_POST['idConjunto'];
        $idRol=$_SESSION['idRol'];
        if($idRol!=1){
            try{
               $this->informacionArchivos($usuario, $idCurso, $idConjunto, $idRol);
             } catch(ValueError $e){
                 http_response_code(404);
                 echo "{error:\"ocurrio un error, con la peticion\"}";
             }
             exit();
        }
        $idCuenta=$_POST['idCuenta'];
        try{
            $this->informacionArchivos($idCuenta, $idCurso, $idConjunto, $idRol);
         } catch(ValueError $e){
             http_response_code(404);
             echo "{error:\"ocurrio un error, con la peticion\"}";
         }
         exit();
    }
    function estadoDelConjunto(){
        /* 
           Solicitar a la base de datos si el conjunto CVV o evidencias esta liberado
        */
        $idUsuario=$_POST['idMaestro'];
        $idCurso=$_POST['idCurso'];
        $idConjunto=$_POST['idConjunto'];
        try{
            echo json_encode($this->modelo->estadoDelConjunto($idUsuario, $idConjunto, $idCurso));
        }catch(Error $error){
            http_response_code(404);
            echo "{error: \"Error al solicitar\"}";
            exit();
        }
        
    }
}
