const urlBase="/curso"//url a donde se harán todas las peticiones

//variables globales
var opcionSeleccionada = ""
var textoEditarAnterior = ""
var opcionesEnlazadasAnterior = ""
var prueba = ""
var idOpcionSeleccionada = ""
var opcionSubMenu=""
//fin variables globales

function crearPrincipal({claveCurso, id}){
    let elemento = document.createElement("li")
    let botonEliminar
    //cambios padre
    elemento.id="opcion"+id
    elemento.classList.add("opcion")
    elemento.classList.add("displayFlexC")
    atributo=crearAtributo("idsql", id)
    agregarAtributo(elemento, atributo)
    elemento.innerHTML = `<div class="conArribaOpcion FlexCentradoR posicionRelativa expandirW flexCentradoR">
        <div class="cuadroOpcion colorPrimario redondear flexCentradoR">
            <img src="public/imagenes/libros.png" class="mitad" alt="">
            <div idSql="${id}" class="opcionesDentro opcionEliminar posicionAbsoluta circulo colorQuinto flexCentradoR">
                <img src="public/iconos/basura.png" class="expandirSetenta" alt="">
            </div>
            <div idSql="${id}" class="opcionesDentro opcionEditar posicionAbsoluta circulo colorCuarto flexCentradoR">
                <img src="public/iconos/configuracion.png" class="expandirSetenta" alt="">
            </div>
        </div>
    </div>
    <div class="conAbajoOpcion displayFlexR ocuparDisponible">
        <p>${claveCurso}</p>
    </div>`

    //modificacion de botoneliminar
    botonEliminar=elemento.childNodes[0].childNodes[1].childNodes[3]
    return {interfaz: elemento, botonEliminar: botonEliminar}
}
function interfazInstructor(informacion){
    id=informacion.id.valor
    nombre=informacion.nombre.valor
    rfc=informacion.rfc.valor
    let elemento = document.createElement("li")
    let botonEliminar
    elemento.id="opcion"+id
    elemento.classList.add("opcion")
    elemento.classList.add("displayFlexC")
   
    atributo=crearAtributo("idsql", id)
    agregarAtributo(elemento, atributo)
    elemento.innerHTML = `<div class="conArribaOpcion FlexCentradoR posicionRelativa expandirW flexCentradoR">
        <div class="cuadroOpcion sombra colorPrimario redondear flexCentradoR" style="position: relative">
            <img src="public/iconos/perfil-del-usuario.png" class="mitad" alt="">
            <div idSql="${id}" class="opcionesDentro sombra opcionAsociadaEliminar posicionAbsoluta circulo colorQuinto flexCentradoR">
                <img src="public/iconos/basura.png" class="expandirSetenta" alt="">
            </div>
            <div idSql="${id}" class="asociado asociadoID posicionAbsoluta redondear sombra colorCuarto flexCentradoR">
               <p>${id}</p>
            </div>
            <div idSql="${id}" class="asociado asociadoRFC posicionAbsoluta sombra colorCuarto textoSeleccionado">
            <p>${rfc}</p>
         </div>
        </div>
    </div>
    <div class="conAbajoOpcion displayFlexR ocuparDisponible">
        <p>${nombre}</p>
    </div>`
    //modificacion de botoneliminar
    botonEliminar=elemento.childNodes[0].childNodes[1].childNodes[3]
    return {interfaz: elemento, botonEliminar: botonEliminar}
}