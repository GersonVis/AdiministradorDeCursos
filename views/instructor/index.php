<?php
include "libs/elemento.php";
include "views/compartido/menuLateral.php";
include "views/compartido/opcion.php";
include "views/compartido/herramienta.php";
$menuLateral = new MenuLateral();
$opcion = new Opcion();
$herramienta=new Herramienta();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    echo $menuLateral->estiloCSS();
    echo $opcion->estiloCSS();
    echo $herramienta->estiloCSS();
    ?>
    <link rel="stylesheet" href="/public/css/estilosPorDefecto.css">
    <link rel="stylesheet" href="/public/css/estilosInstructor.css">
</head>

<body>
    <div id="contenedorPrincipal" class="expandirAmbos">
        <?php
        # echo $menuLateral->codigoHTML();
        ?>
        <section id="menuLateral" class="colorSecundario expandirH flexCentradoC">
            <div id="menuLateralArriba" class="expandirAmbos ">
                <p class="indicador textoTipoA">MENÚ</p>
                <ul id="menu" class="expandirAmbos listaSinEstilo displayFlexC">
                    <li class="opcionMenu flexCentradoR"><a class="textoTipoB redondear colorCuarto expandirAmbos flexCentradoR"><p>Instructores</p></a></li>
                    <li class="opcionMenu flexCentradoR"><a class="textoTipoB redondear colorPrimario expandirAmbos flexCentradoR"><p>Cursos</p></a></li>
                </ul>
            </div>
            <div id="menuLateralAbajo" class="expandirAmbos">
                <p class="indicador textoTipoA">HERRAMIENTAS</p>
                <ul id="menu" class="expandirAmbos listaSinEstilo displayFlexC">
                   <?php
                     echo $herramienta->codigoHTML("/public/iconos/agregar-usuario.png");
                   ?>
                </ul>
            </div>
        </section>

        <div class="ocuparDisponible displayFlexC cuartoColor">
            <footer id="barraBusqueda" class="expandirW flexCentradoR">
                <section id="busqueda" class="mitad">
                    <form action="/instructor/busqueda" class="expandirAmbos flexCentradoR" method="POST">
                        <input id="buscar" type="text" name="busqueda" class="colorCuarto redondear">
                        <input id="botonEnviar" type="submit" class="colorPrimario redondear" value="">
                    </form>
                </section>

            </footer>
            <section id="contenedorOpciones" class="ocuparDisponible barras">
                <ul class="expandirAmbos displayFlexC">
                    <?php for ($posC = 0; $posC < 4; $posC++) { ?>
                        <ul class="opcionesHorizontal expandirW flexCentradoR">
                            <?php
                            for ($pos = 0; $pos < 4; $pos++) {
                                echo $opcion->codigoHTML();
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </ul>
            </section>
        </div>
    </div>
    <script src="/public/js/mostrarInformacion.js"></script>
</body>

</html>