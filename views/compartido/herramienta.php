<?php
 class Herramienta extends Elemento{
    function __construct()
    {
        
    }
    function estiloCSS(){
        return '<link rel="stylesheet" href="/public/css/estiloHerramienta.css">';
    }
    function codigoHTML($imagenHerramienta){
        return ' <li id="" class="opcion displayFlexC">
        <div class="conArribaOpcion FlexCentradoR posicionRelativa expandirW flexCentradoR">
            <div class="cuadroOpcion colorPrimario redondear flexCentradoR">
                <img src="'.$imagenHerramienta.'" class="mitad" alt="">
            </div>
        </div>
        <div class="conAbajoOpcion displayFlexR ocuparDisponible">
            <p class="textoTipoD">crear</p>
        </div>
    </li>';
    }
 }
?>