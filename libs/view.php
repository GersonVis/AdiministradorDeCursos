<?php
   class View{
       function __construct()
       {
           
       }
       function renderizar($nombreVista){
           require "views/$nombreVista.php";
       }
   }
?>