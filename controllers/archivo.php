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
        foreach($_FILES as $identificador=>$archivo){
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

    /*    $respuesta = $this->modelo->eliminar($_POST['id']);
        if (!$respuesta) {
            echo $respuesta->error;
            http_response_code(404);
            exit();
        }
        $informacion = $this->modelo->obtenerInformacion($_POST['id']);
        if ($informacion->num_rows() != 0) {
            http_response_code(404);
            exit();
        }*/
    }
    function registroArchivosSubidos(){
        $usuario=$_SESSION['id'];
        $idCurso=$_POST['idCurso'];
        $idConjunto=$_POST['idConjunto'];
        $idRol=$_SESSION['idRol'];
       try{
           // echo json_encode($this->modelo->consultarArchivosGrupo($usuario, $idCurso, $idConjunto));
           $registroArchivos=$this->modelo->consultarArchivosGrupo($usuario, $idCurso, $idConjunto);
           foreach($registroArchivos as $etiqueta=>$datos){
                $idArchivo=$datos['id']['valor'];
                $permisos=$this->modelo->consultarPermiso($idArchivo, $idRol);
                $datos["permiso"]=array("valor"=>count($permisos)?"true":"false");
                $registroArchivos[$etiqueta]=$datos;
              
           }
           echo json_encode($registroArchivos[0]);
        } catch(ValueError $e){
            http_response_code(404);
            echo "{error:\"ocurrio un error, con la peticion\"}";
            exit();
        }
       
    }

}
