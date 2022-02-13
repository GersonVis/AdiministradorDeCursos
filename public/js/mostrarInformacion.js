const listaOpciones= document.querySelectorAll('.opcion')
const opcionesHorizontal=document.querySelectorAll('.opcionesHorizontal')
listaOpciones.forEach(elemento=>{
    elemento.addEventListener('click', function(){
      contenedorOpciones.style.width=contenedorOpciones.style.width=="200px"?"100%":"200px"
      aplicarCambio(opcionesHorizontal, "flex-direction", "column")
    })
})
function mostrarInformacion(){}

function aplicarCambio(elementos, estilo, actualizacion){
    elementos.forEach(elemento=>{
        elemento.style=`${estilo}: ${actualizacion}`
    })
}