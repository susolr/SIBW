$(document).ready(function() {
    searchbar.oninput = hacerPeticionAjax;  
    console.log("Preparando");  
  });
  
  function hacerPeticionAjax() {
      var str = $("#searchbar").val();
      console.log("Buscando: " + str);

    if(str.length === 0){
        $("#results").css("display", "none");
        $("#comentarios_list").css("display", "grid");
        console.log("Busqueda vacia. Mostrando todos los comentarios")
        return;
    }
      
    $.ajax({
        data: {str},
        url: 'buscarComentarios.php',
        type: 'get',
        success: function(respuesta) {
          procesaRespuestaAjax(respuesta, str);
        }
    });
  }
  
  function procesaRespuestaAjax(respuesta, str) {
      res = "";
      //console.log("Respuesta " + respuesta);
      
      if (respuesta.length>0 && respuesta!="null"){
        var texto = JSON.parse(respuesta);
        //console.log("Texto " + texto);
        for (i = 0 ; i < texto.length ; i++) {
          console.log("ID: " + texto[i].id);
          var producto = resaltar(str, texto[i].producto);
          var autor = resaltar(str, texto[i].autor);
          var fecha = resaltar(str, texto[i].fecha);
          var text = resaltar(str, texto[i].texto);
          res += "<div class=panel><p>" + producto + "</p>"+
          "<div class=autor><p>" + autor + "</p></div>"+
          "<div class=comentario><p>" + text + "</p></div>";
          if (texto[i].modificado == 1){
            res+= "<div class=modificado><p> Comentario modificado por un moderador</p></div>"
          }
          res += "<div class=fecha>" + fecha + "</div>" +
          "<div class=editarBorrarComentario>" + 
          "<a href=/borrarComentario.php?id="+ texto[i].id + "><img class=icono src=https://icons-for-free.com/iconfiles/png/512/delete+remove+trash+trash+bin+trash+can+icon-1320073117929397588.png /></a>" +
          "<a href=/editarComentario.php?id=" + texto[i].id + "><img class=icono src=https://cdn.iconscout.com/icon/free/png-256/edit-2653317-2202989.png /></a>" + 
          "</div></div><br><br>";
        }
        //console.log("Res " + res);  
        $("#results").html(res);             
      }
      else{
        $("#results").html("No hay comentarios");
      }

      $("#results").css("display", "grid");
      $("#comentarios_list").css("display", "none");
      
      
  }

  function resaltar(modelo, remplazar){
    var cadena = modelo;
    var replacement = "<strong>" + cadena + "</strong>";
    var destacado;
    console.log("Resaltando: " + cadena + " en " + remplazar);
    if(cadena.length > 0){
        destacado = remplazar.replace(new RegExp(cadena,"gi"), replacement);
    }

    return destacado;

  }
  