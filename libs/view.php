<?php
   class View{
       function __construct()
       {
           
       }
       function renderizar($nombreVista){
           require "view/$nombreVista.php";
       }
   }
?>