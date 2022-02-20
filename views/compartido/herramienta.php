<?php
 class Herramienta extends Elemento{
    function __construct()
    {
        
    }
    function estiloCSS(){
        return '<link rel="stylesheet" href="/public/css/estilosHerramienta.css">';
    }
    function codigoHTML($imagenHerramienta, $id){
        return ' <li id="'.$id.'" class="herramienta displayFlexC">
        <div class="conArribaOpcion FlexCentradoR posicionRelativa expandirW flexCentradoR">
            <div id="'.$id.'" class="cuadroOpcion colorPrimario redondear flexCentradoR">
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