

crearInstructor.addEventListener('click', function () {
   mostrarElemento(sectionCrearInstructor)
})
botonCerrarCrear.addEventListener('click', function(){
    ocultarElemento(sectionCrearInstructor)
})
botonCrear.addEventListener('click', function (){
    enviarFormulario("crearinstructor", "instructor creado correctamente", "no se pudo crear instructor")
})

function crearFormularioInstructor(nombresLabels) {
    elementos = []
    for (columna of nombresLabels) {
        elemento = interfazDatoIndividuo(columna, "", identificadorFormulario)
        elementos.push(elemento)
    }
    return elementos
}

le = ""
async function clickCrearInstructor(elemento) {
    if (opcionSeleccionada != elemento && opcionSeleccionada != "") {
        quitarClase(opcionSeleccionada, "opcionSeleccionada")
        mostrarInformacion(informacionIndividual)
        agregarClase(elemento, "opcionSeleccionada")
        opcionSeleccionada = elemento
        crearFormularioConsulta()
    } else {
        crearFormularioConsulta()
        mostrarInformacion(informacionIndividual)
        opcionSeleccionada = elemento
    }
}

async function crearFormularioConsulta() {//crea un formulario pidiendo los datos de las columnas para ser rellenadas
    listaDatosIndividuo.innerHTML = ""
    let columnas = await solicitarDatosJSON('/instructor/columnas')
    let formularioElementos = crearFormularioInstructor(columnas)
    formularioElementos.forEach(elemento => {
        listaDatosIndividuo.append(elemento)
    })
}