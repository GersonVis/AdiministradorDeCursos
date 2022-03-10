botonSubirArchivo.addEventListener("click", function(){
    enviarFormulario("formularioSubirArchivo")
    .then(respuesta=>{
        console.log(respuesta.text())
    })
    .catch(error=>{
        console.log(error)
    })
})