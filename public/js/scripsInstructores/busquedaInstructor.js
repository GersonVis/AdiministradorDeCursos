
dat=""
botonEnviar.addEventListener('click', function(){
    contenedorOpcionesDirecto.innerHTML=""
    enviarFormulario('formularioBusqueda')
    .then(respuesta=>respuesta.json())
    .then(datos=>{
        seleccionarOpcion(this, subMenu)
        actualizarPanel(datos, crearPrincipal)
        console.log(datos)
    })
    
})