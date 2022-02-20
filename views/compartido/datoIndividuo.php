<?php
 class DatoIndividuo extends Elemento{
    function __construct()
    {
        
    }
    function estiloCSS(){
        return '<link rel="stylesheet" href="/public/css/estilosDatoIndividuo.css">';
    }
    function codigoHTML($imagenHerramienta="", $etiqueta="", $valor=""){
        return '  <li class="datoPanelIndividuo flexCentradoR">
        <p class="etiquetaDato">'.$etiqueta.'</p>
        <div class="contenedorEditar colorCuarto redondearDos ocuparDisponible">
            <input type="text" name="'.$etiqueta.'" class="textoIndividuo colorCuarto redondearDos" value="'.$valor.'" >
            <div class="cajaOpcionesEdicion flexCentradoR">
                <button class="botonAccion circulo colorPrimario flexCentradoR">
                   <img src="/public/iconos/cheque.png" alt="" class="imagenEditar ">
                 </button>
                <button class="botonAccion circulo colorPrimario flexCentradoR">
                   <img src="/public/iconos/cerrar.png" alt="" class="imagenEditar ">
                </button>
            </div>
        </div>
    </li>';
    }
 }
 /* <button class="botonEditarInformacion circulo colorPrimario flexCentradoR">
                <img src="/public/iconos/editar.png" alt="" class="imagenEditar ">
            </button> */
?>