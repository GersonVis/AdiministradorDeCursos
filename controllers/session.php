<?php
include_once 'controllers/main.php';
 class Session extends Controller{
     function __construct()
     {
         parent::__construct(false);
         $this->view->estilo="colorSecundario";
        
     }
     function registrar(){
            $usuario=isset($_POST['usuario'])?$_POST['usuario']:"";
            $clave=isset($_POST['clave'])?$_POST['clave']:"";
            if($usuario!="" && $clave!=""){
                $respuesta=$this->modelo->usuario($usuario, $clave);
                $registro=$respuesta->fetch_assoc();
                if($respuesta){
                     $_SESSION['nombre']=$registro['nombre'];
                     $_SESSION['clave']=$registro['clave'];
                     $_SESSION['grado']=$registro['grado'];
                    // $grado=$_SESSION['grado'];
                     header('location: /main'); 
                }
            } 
            $this->view->estilo="colorError";
            $this->Renderizar("<session/index");
        
       
        
       // header('location: /main');
     }
     function error(){
         $this->view->estilo="colorError";
         $this->Renderizar('session/index');
     }
     function salir(){
         if(isset($_SESSION)){
             unset($_SESSION['nombre']);
             unset($_SESSION['clave']);
             unset($_SESSION['grado']);
         }
         header('location: /session');
     }
 }
