<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php require_once "views/header.php"; ?>
    <main>
        <h1>FORMULARIO</h1>
        <div>
            <form action="/inicio/registrar" method="POST">
               <p><label for="">Nombre: <input name="nombre" type="text" required></label></p> 
                <label for="">Apellido: <input name="apellido" type="text"></label>
                <label for="">RFC: <input name="rfc" type="text" required></label>
                <label for="">Clave: <input type="text" name="clave"></label>
                <label for="">Localidad: <input type="text" name="localidad"></label>
                <input type="submit" value="Enviar">
            </form>

        </div>
    </main>
    <?php require_once "views/footer.php";
    ?>
</body>

</html>