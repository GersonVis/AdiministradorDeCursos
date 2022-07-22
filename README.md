# AdiministradorDeCursos
> Es un sitio de administración de cursos, donde los las personas pueden llevar un seguimiento de los cursos que se van tomando, pasando lista a las personas inscritas en cada curso, al final se solicita una constancia de liberación en donde el instructor tiene la posibilidad de denegar dicha solicitud o aprobar
## Tecnologías utilizadas
* PHP Version 8.0.14
* Jasvascript
* 10.4.22-MariaDB
* HTML5
* CSS3
## Estado
> El sitio se encuentra en etapa de pruebas
## Bugs conocidos
* La carga de maestros no es óptima
* Arroja un error al visualizar usuarios, solución: cerrar cuadro de diálogo
## Guía
> El sistema cuenta con los siguientes roles:
* **Maestro**: Buscar cursos, tomar curso, solicitar la liberación de constacia, ver archivos, subir archivos
* **Instructor**: Liberar constancia, agregar maestros a curso, eliminar maestros de curso, dar seguimiento del maestro tomando el curso
* **Administrador**: Crear, editar, eliminar maestros, cambiar contraseñas, quitar instructores, crear cursos
### Registro
> Se necesita un usario y una contraseña creado por el administrador
> Puedes usar un usuario de prueba:
> 
> usuario: anastacio contraseña: 1234578

<img src="https://github.com/GersonVis/AdiministradorDeCursos/blob/master/recursos/inicio.PNG?raw=true"></img>

> Al ser la primera vez en iniciar sesión con ese usuario, nos permitirá poder cambiar el nombre de usuario que nosotros queramos y una contraseña nueva, la contraseña debe tener un mínimo de 8 dígitos

<img src="https://github.com/GersonVis/AdiministradorDeCursos/blob/master/recursos/Captura.PNG?raw=true"></img>

### Pantalla principal
> Podremos ver el menú a la izquierda, una barra de búsqueda, un botón para crear un nuevo maestro y el botón rojo para poder eliminar un maestro

<img src="https://github.com/GersonVis/AdiministradorDeCursos/blob/master/recursos/inicio%20portal.PNG?raw=true"></img>
### Información de los elementos
> Al hacer click en alguno de los maestros nos desplegará detalles de tal maestro, las acciones posibles son:
* Actualizar información al pulsar el botón de actualizar, si la información es la misma nos arrojará un mensaje de error
* Asignar un curso para cada profesor
* Modificar sus datos de usuario

<img src="https://github.com/GersonVis/AdiministradorDeCursos/blob/master/recursos/informacion%20maestro.PNG?raw=true"></img>

