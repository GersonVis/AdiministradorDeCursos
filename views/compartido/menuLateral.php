<?php
   class MenuLateral extends Elemento{
       function __construct()
       {
           
       }
       function estiloCSS(){
           return '<link rel="stylesheet" href="/public/css/estilosMenuLateral.css">';
       }
       function codigoHTML(){
           return '<section id="menuLateral" class="colorSecundario expandirH"></section>';
       }
   }
  
?>