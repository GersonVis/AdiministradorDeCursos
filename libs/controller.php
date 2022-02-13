<?php
   class Controller{
       function __construct()
       {
           $this->view=new View();
       }
       function CargarModelo($modelo){
           $url = "models/$modelo"."Modelo.php";
           if(file_exists($url)){
               require_once $url;
               $modelo=$modelo.'Modelo';
               $this->model=new $modelo();
           }
       }
       function Renderizar($vista){
           $this->view->Renderizar("$vista");
       }
   }
?>