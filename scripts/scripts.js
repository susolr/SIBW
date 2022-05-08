var comentarios = new Array();
//var palabras_prohibidas = ["haiga", "asin", "gordo", "gorda", "zorra", "guarro", "guarra", "perra", "gilipollas", "idiota"];
var palabras_prohibidas;
var peticion = new XMLHttpRequest();
peticion.onreadystatechange = function(){
    if (peticion.readyState == 4 && peticion.status==200){
        palabras_prohibidas = JSON.parse(this.responseText);
    }
}

//peticion.open('GET', 'palabras_prohibidas.php', true);
peticion.open('GET', 'palabras_prohibidas.php', true);
peticion.send();

var comentario1 = {
    autor:"Jesús",
    fecha: "17/03/2021",
    hora: "10:33",
    texto: "Producto altamente recomendable debido a su gran calidad"
};

var comentario2 = {
    autor:"Fran",
    fecha: "13/02/2021",
    hora: "18:53",
    texto: "Muy mala experiencia con el producto"
};

var comentarios_mostrados = false;

comentarios.push(comentario1);
comentarios.push(comentario2);

function mostrarComentarios(){
    const authLabel = "Autor";
    const dateLabel = "Fecha y Hora";
    const contentLabel = "Comentario";
    for (let i = 0; i < comentarios.length; i++){

        const para = document.createElement("div");
        para.className = "comentario";
        var ind = (i+1);
        var id = "comentario" + ind;
        para.id = id;

        /*Autor*/
        //Label
        var p = document.createElement("p");
        p.className ="label";
        var label = document.createTextNode(authLabel);
        label.className = "autor-label";
        label.id = "autor-label" + ind;
        p.appendChild(label);
        para.appendChild(p);
        
        //Contenido
        p = document.createElement("p");
        p.className = "contenido";
        var content = document.createTextNode(comentarios[i].autor);
        content.className = "autor";
        content.id = "autor" + ind;
        p.appendChild(content);
        para.appendChild(p);

        /*Fecha y hora*/
        //Label
        p = document.createElement("p");
        p.className ="label";
        label = document.createTextNode(dateLabel);
        label.className = "date-label";
        label.id = "date-label" + ind;
        p.appendChild(label);
        para.appendChild(p);

        //Contenido
        p = document.createElement("p");
        p.className = "contenido";
        content = document.createTextNode(comentarios[i].fecha + " " + comentarios[i].hora);
        content.className = "date";
        content.id = "date" + ind;
        p.appendChild(content);
        para.appendChild(p);

        /*Comentario*/
        //Label
        p = document.createElement("p");
        p.className ="label";
        label = document.createTextNode(contentLabel);
        label.className = "content-label";
        label.id = "content-label" + ind;
        p.appendChild(label);
        para.appendChild(p);

        //Contenido
        p = document.createElement("p");
        p.className = "contenido";
        content = document.createTextNode(comentarios[i].texto);
        content.className = "content";
        content.id = "content" + ind;
        p.appendChild(content);
        para.appendChild(p);

        const element = document.getElementById("comentarios-sidepanel");
        const child = document.getElementById("formulario-comentario");
        element.insertBefore(para, child);
    }
}

function vaciarComentarios(){
    var i = 1;
    var comentario = "comentario" + i;
    var element = document.getElementById(comentario);
    while (element!=null){
        element.remove();
        i = i+1;
        comentario = "comentario" + i;
        element = document.getElementById(comentario);
    }
}

function mostrarComentariosPanel(){
    if(!comentarios_mostrados){
        mostrarComentarios();
        comentarios_mostrados = true;
    }
    document.getElementById("comentarios-sidepanel").style.width= "40%";
}

function esconderComentarios(){
    document.getElementById("comentarios-sidepanel").style.width= "0";
}

function mostrarComentarioOculto(){
    document.getElementById("comentario-oculto").style.display= "block";
}

function comprobarEmail(email){ 
    var emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

    var correo_correcto = emailRegex.test(email);

    return correo_correcto;
}

function comprobarNombre(nombre){
    return (nombre!="");
}

function comprobarContenido(contenido){    
    return (contenido!="");
}

function filtrarContenido(contenido){
    /*
    while(palabras_prohibidas === null){
        var peticion = new XMLHttpRequest();
        peticion.onreadystatechange = function(){
            if (peticion.readyState == 4 && peticion.status==200){
                palabras_prohibidas = JSON.parse(this.responseText);
                console.log(palabras_prohibidas);
            }
        }
    
        //peticion.open('GET', 'palabras_prohibidas.php', true);
        peticion.open('GET', 'palabras_prohibidas.php', true);
        peticion.send();

    }*/
    var list = contenido.split(" ");
    
    for(let i = 0; i < list.length; i++){
        var palabra = list[i].toLowerCase();
        //console.log("Palabra: " + palabra);
        var indice = palabras_prohibidas.indexOf(palabra);
        if(indice!=-1){
            var sust = "";
            for (let j = 0; j < list[i].length; j++){
                sust = sust + "*";
            }
            list[i] = sust;
        }
    }
    contenido = list[0];
    for (let i = 1; i < list.length; i++){
        contenido = contenido + " " + list[i];
    }
    document.getElementById('coment').value = contenido;
}

function mostrarError(mensaje){
    alert(mensaje);
}

function publicarComentario(){
    var email = document.getElementById('email').value;
    var errores = 0;
    var email_correcto = comprobarEmail(email);
    var mensaje = "";
    if(!email_correcto){
        mensaje = mensaje + "El correo introducido es inadecuado\n";
        //mostrarError("El correo introducido es inadecuado");
        //document.getElementById('email').value = "";
        errores = errores + 1;
    }

    var nombre = document.getElementById('nombre').value;
    var nombre_correcto = comprobarNombre(nombre);

    if(!nombre_correcto){
        mensaje = mensaje + "El nombre está vacío\n";
        //mostrarError("El nombre está vacío");
        //document.getElementById('nombre').value = "";
        errores = errores + 1;
    }
    
    var content = document.getElementById('coment').value;
    var content_correcto = comprobarContenido(content);

    if(!content_correcto){
        mensaje = mensaje + "El comentario está vacío\n";
        //mostrarError("El comentario está vacío");
        //document.getElementById('coment').value = "";
        errores = errores + 1;
    }

    if (errores == 0){
        const d = new Date();
        var f = d.getDate() + "/" + d.getMonth()+ "/" + d.getFullYear();
        var h = d.getHours() + ":" + d.getMinutes();
        var com = {
            autor: nombre,
            fecha: f,
            hora: h,
            texto: content
        };
        comentarios.push(com);
        vaciarComentarios();
        mostrarComentarios();
    }
    else{
        mostrarError(mensaje);
    }
}

function editarUsuario(id){
    document.getElementById(id).style.display="block";
  }