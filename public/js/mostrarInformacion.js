const listaOpciones= document.querySelectorAll('.opcion')
listaOpciones.forEach(elemento=>{
    elemento.addEventListener('click', function(){
      contenedorOpciones.style.width=contenedorOpciones.style.width=="200px"?"100%":"200px"
      
    })
})
function mostrarInformacion(){}
   