class CambiosInput extends HTMLElement {
    constructor(){
        super()
        this.seleccionado="noSeleccionado"
        this.accion=""
    }
    agregarClases(clases){//recive un array
        agregarClases(this, clases)//esta funcion esta en el archivo funcioens utilies
    
    }
    acccionBoton(padre){//boton para actualizar regsitro en la base de  datos
        let botonActualizar=document.createElement("button")
        botonActualizar.innerHTML="Actualizar"
        agregarClases(botonActualizar, ["buttonCIA", "redondear"])
        botonActualizar.value="Actualizar"
        botonActualizar.addEventListener("click", function(){
           
            if(padre.interfazTextoRegistro.value==padre.valor){
                alert("Los datos son los mismos")
                return false
            }
            padre.accion({id:padre.id, 
                nombreColumna: padre.getAttribute("etiqueta"), 
                valorNuevo: padre.interfazTextoRegistro.value})
           
        })
        return botonActualizar 
    }
    textoRegistro(padre, valor, tipo){//inputtext para modificar los datos en mysql
        let textoRegistro=document.createElement("input")
        textoRegistro.type=tipo
        textoRegistro.placeholder="No tiene valor asignado"
        textoRegistro.value=valor
        agregarClases(textoRegistro, ["ciInputCambiar","redondearDos"])
        textoRegistro.addEventListener("mousedown", function(){
           if(textoEditarAnterior!=""){
            quitarClase(textoEditarAnterior, "seleccionado")
            agregarClase(textoEditarAnterior, "noSeleccionado")
           }
           quitarClase(padre, "noSeleccionado")
           agregarClase(padre, "seleccionado")
           textoEditarAnterior=padre
        })
        return textoRegistro
    }
    renderizar(){
      let etiqueta=this.getAttribute("etiqueta")
      this.valor=this.getAttribute("valor")=="null"?"":this.getAttribute("valor")
      let tipo=this.getAttribute("tipo")
      this.innerHTML='<label>'+etiqueta+'</label>'
      this.agregarClases(["divOF", "redondearDos", "posicionRelativa", "colorCuarto", "noSeleccionado"])
      //elementos creados aparte
      this.interfazTextoRegistro=this.textoRegistro(this, this.valor, tipo)
      this.interfazAccionBoton=this.acccionBoton(this)
      this.appendChild(this.interfazTextoRegistro)
      this.appendChild(this.interfazAccionBoton)
    }
    static get observedAttributes(){
        return ['etiqueta', 'tipo', 'valor']
    }
    connectedCallback(){
       this.renderizar()
       
    }
    attributeChangedCallback(identificador, valorAntiguo, valorNuevo){
        this.renderizar()
    }
}
customElements.define("cambios-input", CambiosInput)