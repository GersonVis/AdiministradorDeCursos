document.addEventListener("DOMContentLoaded", function(){
   solicitarDatosJSON('instructor/todos')
   .then(datos=>{
       datos.forEach(elemento=>{
           interfaz=crearOpcionInstructor((elemento))
           contenedorOpcionesDirecto.appendChild(interfaz)
           interfaz.addEventListener('clicl', function(){
               
           })
       })
   })
})
function soyElemento(ele){
    console.log(ele)
    console.log(ele.id)
}