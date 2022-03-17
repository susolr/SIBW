var comentarios = new Array();

var comentario1 = {
    autor:"Jesús",
    fecha: "17/03/2021",
    texto: "Producto altamente recomendable debido a su gran calidad"
};

var comentario2 = {
    autor:"Fran",
    fecha: "13/02/2021",
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
        var label = document.createTextNode(authLabel);
        label.className = "autor-label";
        label.id = "autor-label" + ind;
        para.appendChild(label);
        var content = document.createTextNode(comentarios[i].autor);
        content.className = "autor";
        content.id = "autor" + ind;
        para.appendChild(content);

        /*Fecha y hora*/
        label = document.createTextNode(dateLabel);
        label.className = "date-label";
        label.id = "date-label" + ind;
        para.appendChild(label);
        content = document.createTextNode(comentarios[i].fecha);
        content.className = "date";
        content.id = "date" + ind;
        para.appendChild(content);

        /*Contenido*/
        label = document.createTextNode(contentLabel);
        label.className = "content-label";
        label.id = "content-label" + ind;
        para.appendChild(label);
        content = document.createTextNode(comentarios[i].texto);
        content.className = "content";
        content.id = "content" + ind;
        para.appendChild(content);

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

    var correo_correcto = emailRegex.test(email.value);

    return correo_correcto;
}

function comprobarNombre(){

}

function mostrarError(){

}

function publicarComentario(){
    var email = document.getElementById('email').innerText;
    console.log(email);
    //var email_correcto = comprobarEmail(email);
    //if(!email_correcto){
    //    return;
    //}
    var nombre = document.getElementById('nombre').innerText;
    console.log(nombre);

    var content = document.getElementById('coment').innerText;
    console.log(content);

}