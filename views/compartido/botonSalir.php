<?php
 class BotonSalir extends Elemento{
    function __construct()
    {
        
    }
    function estiloCSS(){
        return '<link rel="stylesheet" href="/public/css/estilosBotonSalir.css">';
    }
    function codigoHTML(){
        return '<button id="botonSalir" class=" redondear posicionAbsoluta colorQuinto botonSalir"><a href="/session/salir">SALIR<a></button>';
    }
 }