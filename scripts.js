function mostrarComentarios(){
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
    var email = document.getElementById('email').innerHTML();
    var email_correcto = comprobarEmail(email);
    if(email_correcto){
        
    }

}