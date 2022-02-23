document.addEventListener("DOMContentLoaded", function () {
    solicitarDatosJSON(urlBase+"/todos")
        .then(datos => {
            actualizarPanel(datos, crearPrincipal)
        })
})
function actualizarPanel(datos, funcionCrear) {
    datos.forEach(elemento => {
        const { interfaz, botonEliminar } = funcionCrear({claveCurso: elemento.claveCurso.valor, id: elemento.id.valor})
        contenedorOpcionesDirecto.appendChild(interfaz)
        interfaz.addEventListener('click', function () {
            opcionClick(this)
        })
        botonEliminar.addEventListener('click', function (e) {
            e.stopPropagation()
            res = this
            let resultado = confirm("eliminar")
            if (resultado) {
                procesoDeEliminacion(this)
            }
        })
    })

}