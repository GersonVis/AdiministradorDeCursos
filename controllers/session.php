<?php
include_once 'controllers/main.php';
 class Session extends Controller{
     function __construct()
     {
         parent::__construct();
         $this->view->estilo="colorSecundario";
     }
     function Registrar(){
        session_start();
        if(!isset($_SESSION['usuario'])){
            header('location: /main');
        }
        if(!isset($_POST['usuario']) && !isset($_POST['clave'])){
            $this->Error();
        }else{
            $_SESSION['usuario']=$_POST['usuario'];
            $_SESSION['clave']=$_POST['clave'];
            header('location: /main');
        }
     }
     function Error(){
         $this->view->estilo="colorError";
         $this->Renderizar('session/index');
     }
     
 }
?>