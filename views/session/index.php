<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <link rel="stylesheet" href="/public/css/estilosPorDefecto.css">
    <link rel="stylesheet" href="/public/css/estilosInicio.css">
    <title>Document</title>
</head>

<body class="centrar colorBase">
    <div class="centrar flexCentrado contenedorRegistro redondear <?php  echo $this->estilo;?>">
        <img class="imagen" src="/public/imagenes/persona sentada.png" alt="">
        <div class="formularioInicio centrar expandir">
            <form action="/session/Registrar" id="formRegistro"class="expandirAmbos centrar formInicio">
                <input type="text" class="capturarTexto expandir seleccionado" placeholder="Usuario">
                <input type="password" class="capturarTexto expandir noSeleccionado" placeholder="Contraseña">
            </form>
        </div>
        <div class="centrar expandir contenedorEnviar colorPrimario hacerCirculo">
           <!-- <img src="/public/iconos/sign-in-alt-solid.svg" alt="" class="icono">-->
           <input form="formRegistro" type="submit" value="" class="boton centrar expandir contenedorEnviar colorPrimario hacerCirculo">
        </div>
    </div>
</body>

</html>