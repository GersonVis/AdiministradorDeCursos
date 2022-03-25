var padreGlobal2
class PanelSubirArchivo extends HTMLElement{
    constructor(){
        super()
        this.parteTitulo=""
        this.renderizado=false
        this.contenedorPrincipal()
        this.contadorArchivos=0
    }
    //funciones reutilizables
    crearImagen(rutaImagen){
        let imagenIcono=document.createElement("img")
        imagenIcono.src=rutaImagen
        agregarClases(imagenIcono, ["imgPSAImagen", "expandirSetenta"])
        return imagenIcono
    }
    //este contenedor es el contenedor principal
    contenedorPrincipal(){
        this.padre=document.createElement('div')
        this.padre.style.width="90%"
        agregarClases(this.padre, ['divPSAPadre', 'flexCentradoC'])
        this.appendChild(this.padre)
    }
    //hijos de contenedorPrincipal
    crearTitulo(titulo){
       let padre
       padre=document.createElement('div')
       padre.innerHTML=`<label class="textoTipoD">${titulo}</label>`
       agregarClases(padre, ['divPSAPadreTitulo', 'flexCentradoR', 'redondearDos', 'colorCuarto'])
       return padre
    }
    crearContenedorArchivosAgregados(){ //elemento que contiene la interfaz de archivos agregados
        let contenedorBotonesSubirArchivo=document.createElement('div')
        let botonSubirArchivo=this.crearBotonSubirArchivos(this)
        agregarClases(contenedorBotonesSubirArchivo, ['divPSAPadreSubirArchivo', 'flexCentradoR', 'colorCuarto', 'redondearDos', 'posicionRelativa'])
       // this.padre.appendChild(contenedorBotonesSubirArchivo)
         contenedorBotonesSubirArchivo.appendChild(botonSubirArchivo)
        return contenedorBotonesSubirArchivo
    }
    crearFormularioArchivosAgregados(){//formulario oculto que subira los archivos a la api
        let formulario=document.createElement('form')
        formulario.action=this.getAttribute('urlEnviar')
        formulario.method="POST"
        formulario.innerHTML=`<input style="display: none" name="idCurso"value="${this.getAttribute("idsql")}"></input><input style="display: none" name="idConjunto"value="${this.getAttribute("idConjunto")}"></input>`
        return formulario
    }
    crearInterfazArchivos(){
        let divPadre=document.createElement('div')
        agregarClases(divPadre, ['divPSAContenedorAgregar'])
        return divPadre
    }
    crearContenedor(clases){
        let divPadre=document.createElement('div')
        agregarClases(divPadre, clases)
        return divPadre
    }
    //hijos de crearAgregarArchivos
    crearAccionArchivo(titulo,subtitulo,imagen, padreGlobal){//abre una ventana para subir archivo
        let botonAccion=document.createElement('div')
        let contenedorImagen=document.createElement('div')
         let imagenIcono=this.crearImagen(imagen)
        let tituloBoton=document.createElement('abbr')
        
        //ediciones directas del elemento
        
        tituloBoton.innerText=titulo
        tituloBoton.title=subtitulo
        //clases css agregadas a los elementos
        agregarClases(botonAccion, ['divPSAPadreCrearAccionArchivo','redondearDos', "flexCentradoC", "colorFondo", "sombraDos", "posicionRelativa"])
         agregarClases(contenedorImagen, ["divPSAContenedorImagen", "flexCentradoR", "redondear", "colorCuarto"])
           

         agregarClases(tituloBoton, ["abbrPSATitulo"])
                
        //agregar elementos dentro de sus padres
        botonAccion.appendChild(contenedorImagen)
         contenedorImagen.appendChild(imagenIcono)
        botonAccion.appendChild(tituloBoton)
        botonAccion.addEventListener("click", function(){
            let inputArchivo=document.createElement("input")
            inputArchivo.type="file"
            inputArchivo.id="archivo"
            inputArchivo.style.display="none"
            inputArchivo.id="archivo"
            padreGlobal.formularioArchivos.appendChild(inputArchivo)
            inputArchivo.click()
            inputArchivo.addEventListener("change", function(){
                let nombre, archivoInterfaz, peso, archivo
                let datosExtra
                archivo=this.files[0]
                nombre=archivo.name
                peso="Peso: "+archivo.size
                datosExtra={
                    formulario: padreGlobal.formularioArchivos,
                    inputArchivo: inputArchivo
                }
                archivoInterfaz=padreGlobal.interfazReferenciaAArchivo(nombre, peso, "public/iconos/archivo-agregado.png", padreGlobal.listaArchivos, "visible", function({formulario, inputArchivo}){
                    formulario.removeChild(inputArchivo)
                }, datosExtra)
                padreGlobal.listaArchivos.appendChild(archivoInterfaz)
                padreGlobal.contadorArchivos++
                inputArchivo.name="archivo"+padreGlobal.contadorArchivos
            }, false)
        })
        return botonAccion
    }
    
    interfazReferenciaAArchivo(titulo, peso, icono, padre, display="none", funcionBotonEliminar=function(){}, datosExtra){//interfaz de cada archivo agregado al formulario
        //crea la interfaz de cada archivo seleccionado, se puede quitar o poner el boton de eliminar con display
        //la function que se pasa en el metodo contiene lo que se hara en el botonEliminar
        let divPrincipal=document.createElement('div')
        let contenedorImagen=document.createElement('div')
         let imagenIcono=this.crearImagen(icono)
        let tituloBoton=document.createElement('abbr')
        let botonEliminar=document.createElement("button")//elimina el archivo del formulario del formulario
         let imagenBoton=this.crearImagen("public/iconos/basura.png")
        //ediciones directas del elemento
        
        tituloBoton.innerText=titulo
        tituloBoton.title=peso
        botonEliminar.style.display=display
       // botonEliminar.innerText="Eliminar"
        //clases css agregadas a los elementos
        agregarClases(divPrincipal, ['divPSAPadreRerefenciaAArchivo','redondearDos', "flexCentradoC", "colorFondo", "sombraDos", "posicionRelativa"])
         agregarClases(contenedorImagen, ["divPSAContenedorImagen", "flexCentradoR", "redondear", "colorCuarto"])
        agregarClases(tituloBoton, ["abbrPSATitulo"])
        agregarClases(botonEliminar, ["buttonPSABotonEliminar","flexCentradoR", "colorQuinto"])
                
        //agregar elementos dentro de sus padres
        divPrincipal.appendChild(contenedorImagen)
         contenedorImagen.appendChild(imagenIcono)
        divPrincipal.appendChild(tituloBoton)
        divPrincipal.appendChild(botonEliminar)
          botonEliminar.appendChild(imagenBoton)
                    //quitar elemento visualmente, solicita a la base de datos para remover del registro y servidor
                    botonEliminar.addEventListener("click", function(){
                        padreGlobal2=padre
                        padre.removeChild(divPrincipal)
                    })
                    botonEliminar.addEventListener("click", function(){
                       funcionBotonEliminar(datosExtra||"")
                    })

        return divPrincipal
    }
    crearListaArchivos(){
        let divPadre=document.createElement('div')
        agregarClases(divPadre, ['divPSAContenedorAgregar'])
        return divPadre
    }
    //boton con posicion absoluta
    crearBotonSubirArchivos(padreGlobal){
        let botonSubir=document.createElement('button')
        let imagenSubir=this.crearImagen("public/iconos/file.png")
        agregarClases(botonSubir, ['buttonPSABotonSubirArchivo', 'posicionAbsoluta', 'redondear', 'BotonCircular'])
        botonSubir.appendChild(imagenSubir)
        botonSubir.addEventListener("click", function(){
            let respuesta
          //  respuesta=confirm("¿Está seguro de enviar estos archivos?")
            //if(respuesta){
                padreGlobal.enviarFormularioConElemento(padreGlobal.formularioArchivos)
                .then(respuesta=>respuesta.text())
                .then(texto=>{
                    alert(texto)
                })
                .catch(error=>{
                    alert("No se pudo enviar")
                })
          //  }
        })
        return botonSubir
    }
    //metodos hacia api
    async enviarFormularioConElemento(formulario){
        let data=new FormData(formulario)
        let respuesta =await fetch(formulario.action, {
            method: formulario.method,
            body:data
        })
        return respuesta
    }
    solicitarArchivos(padreGlobal){
        let informacion=new FormData()
        var padreGlobal
        informacion.append("idCurso", this.getAttribute('idsql'))
        informacion.append("idConjunto", this.getAttribute('idconjunto'))
     
        fetch(this.getAttribute("urlInformacion"), {
            method: "POST",
            body: informacion 
        })
        .then(respuesta=>{
            console.log(respuesta.text())
        })
       
    /*  .then(respuesta=>respuesta.json())
        .then(data=>{
            data.forEach(objeto => {
                //añadimos cada nombre de archivo a la interfaz
                let nombre=objeto.nombre.valor
                let archivoInterfaz
                console.log(padreGlobal.interfazReferenciaAArchivo.toString())
                archivoInterfaz=padreGlobal.interfazReferenciaAArchivo(nombre, nombre, "public/iconos/archivo-agregado.png", padreGlobal.listaArchivos)
                padreGlobal.listaArchivos.appendChild(archivoInterfaz)
            });
        })*/
        .catch(error=>{
            alert("Error al consultar archivos")
        })
      /*  .catch(error=>{
            alert("no se pudo realizar la consulta")
        })*/
    }
    //metodo que se lanza al añadir al DOM
    renderizar(){
       let botonAgregarArchivo, contenedorDivAgregar, contenedorListaArchivos
       this.style.width="100%"
       this.formularioArchivos=this.crearFormularioArchivosAgregados()


       this.contenedorArchivosAgregados=this.crearContenedorArchivosAgregados()
       this.listaArchivos=this.crearContenedor(['divPSAListaArchivos', "flexCentradoR"])
 
       contenedorDivAgregar=this.crearContenedor(['divPSAContenedorAgregar', 'flexCentradoR'])
       contenedorListaArchivos=this.crearContenedor(['divPSAContenedorListaArchivos', 'barraDeDesplazamiento'])


       botonAgregarArchivo=this.crearAccionArchivo("Agregar","Seleccionar archivo a agregar", "public/iconos/agregar-archivo.png", this)//este boton se encuentra por separado con posicion absoluta
      // this.padre.appendChild(contedorDivAgregar)
            contenedorDivAgregar.appendChild(botonAgregarArchivo)
       this.padre.appendChild(this.contenedorArchivosAgregados)
            this.contenedorArchivosAgregados.appendChild(contenedorDivAgregar)
                 contenedorDivAgregar.appendChild(botonAgregarArchivo)
            this.contenedorArchivosAgregados.appendChild(contenedorListaArchivos)
                 contenedorListaArchivos.appendChild(this.listaArchivos)
       this.padre.appendChild(this.formularioArchivos)
       agregarClases(this, ["flexCentradoC"])
       this.solicitarArchivos(this)
    }
    static get observedAttributes(){
        return ['titulo', 'urlEnviar', 'idsql', 'sinboton']
    }
    connectedCallback(){
        if(!this.renderizado){
            this.renderizar()
            this.renderizado=true     
        }
    }
    attributeChangedCallback(identificador, valorAntiguo, valorNuevo){
        switch(identificador){//evita actualizar todo el elemento, solo actualiza el elemento que a sido modificado
            case 'titulo':
                this.parteTitulo=this.crearTitulo(valorNuevo)
                this.padre.appendChild(this.parteTitulo)
                break
        }
        
    }
    prueba(){
        alert("hoña")
    }
}
customElements.define("panel-subir-archivo", PanelSubirArchivo)