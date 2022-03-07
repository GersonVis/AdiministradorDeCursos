botonCerrarEnlazadoPrincipal.addEventListener("click", function () {
    sectionEnlazadoPrincipal.style.visibility = "hidden"

})
var divEnlazadoPrincipal, secundario
[divEnlazadoPrincipal, secundario] = crearInterfazEnlazadoPrincipal()
console.log(divEnlazadoPrincipal)
divInformacionPrincipalEnlazado.appendChild(divEnlazadoPrincipal)


function crearInterfazEnlazadoPrincipal() {
    let elemento = document.createElement('div')
    let elementoPadre = document.createElement('div')
    let parteBotones = document.createElement('div')

    elementoPadreClases = ['barras']
    parteBotonesClases = ['flexCentradoR']

    agregarClases(elemento, elementoClases)
    agregarClases(elementoPadre, elementoPadreClases)
    agregarClases(parteBotones, parteBotonesClases)
    //enlaces de elementos
    elementoPadre.appendChild(elemento)



    elementoPadre.appendChild(parteBotones)
    //edificion de propiedades
    parteBotones.id = "botonesPrincipalEnlazado"


    //estilos

    estilosPadre = {

        width: "100%"
    }
    estilosParteBotones = {
        position: "absolute",
        width: "125px",
        height: "50px",
        bottom: "24px",
        right: "23px"
    }

    agregarEstilos(elementoPadre, estilosPadre)
    agregarEstilos(parteBotones, estilosParteBotones)

    //eventos js
    puerta = true
    let botonConstancia = botonAccionEnlazado("/public/iconos/diploma.png", "/public/iconos/diploma.png")
    let botonLiberar = botonAccionEnlazado("/public/iconos/candado-abierto.png", "/public/iconos/cerrado.png")
    botonConstancia.id = "botonConstancia"
    botonLiberar.id = "botonLiberar"
    elemento.id = "maestroCurso"


    parteBotones.appendChild(botonConstancia)
    parteBotones.appendChild(botonLiberar)

    estilosParteBotones = ".parteBotones{"
    estilosParteBotones += ""
    estilosParteBotones += "}"
    parteBotones.classList.add("parteBotones")
    crearEstilo(estilosParteBotones)


    botonLiberar.addEventListener("click", checarLiberar)
    botonConstancia.addEventListener("click", function(){
        alert("constancia")
    })


    return [elementoPadre, elemento]

}

function checarLiberar() {
    solicitarDatosJSON(urlBase + "/invertirLiberacion", dataCursoMaestro)
        .then(respuestaJSON => {
            botonLiberar.childNodes[0].src = (liberado == "liberado")?"/public/iconos/candado-abierto.png":"/public/iconos/cerrado.png"
        })
}