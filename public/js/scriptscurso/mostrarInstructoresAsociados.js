botonInstructoresAsociados.addEventListener("click", function () {
    informacion = new FormData();
    informacion.append('curso', opcionSeleccionada.attributes.idsql.value)
    solicitarDatosJSON(urlBase + "/instructoresEnlazados", informacion)
        .then(datosJSON => {
            opcionSubMenu=seleccionarOpcion(botonInstructoresAsociados, opcionSubMenu, "textoSeleccionado")
            actualizarInformacionIndividual(datosJSON, listaDatosIndividuo, interfazInstructor)
        })
})
actualizarInformacionIndividual = (datosJSON, contenedorPadre, crearInterfaz) => {
    contenedorPadre.innerHTML = ""
    datosJSON.forEach(elemento => {
        ({ interfaz, botonEliminar } = crearInterfaz(elemento))
        contenedorPadre.appendChild(interfaz)
    });
}
