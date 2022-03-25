botonLiberacionCurso.addEventListener("click", function(){
    opcionSubMenu = seleccionarOpcion(botonLiberacionCurso, opcionSubMenu, "textoSeleccionado")
    listaDatosIndividuo.innerHTML=""
    listaDatosIndividuo.innerHTML=`<panel-subir-archivo titulo="CVV" urlInformacion="/archivo/registroArchivosSubidos"urlEnviar="/archivo/liberacionCurso" idConjunto="2" idsql="${opcionSeleccionada}">`
})