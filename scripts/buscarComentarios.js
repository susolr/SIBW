$(document).ready(function() {
    searchbar.oninput = hacerPeticionAjax;  
    console.log("Preparando");  
  });
  
  function hacerPeticionAjax() {
      var str = $("#searchbar").val();
      console.log("Buscando: " + str);

    if(str.length === 0){
        $("#results").css("display", "none");
        $("#comentarios").css("display", "grid");
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
          var nombre = resaltar(str, texto[i].nombre);
          var subtitulo = resaltar(str, texto[i].subtitulo);
          var contenido = resaltar(str, texto[i].contenido);
          res += "<div class=panel><div class=imagen-principal><img class=icono src=" + texto[i].img_principal + "></div>"+
          "<div class=nombre>" + nombre + "</div>"+
          "<div class=subtitulo>" + subtitulo + "</div>" +
          "<div class=contenido>" + contenido + "</div>" +
          "<div class=irA><a href=producto.php?id=" + texto[i].id + ">Ver producto</a></div>"+ 
          "</div><br><br>";
        }
        //console.log("Res " + res);  
        $("#results").html(res);             
      }
      else{
        $("#results").html("No hay comentarios");
      }

      $("#results").css("display", "grid");
      $("#comentarios").css("display", "none");
      
      
  }

  function resaltar(modelo, remplazar){
    var cadena = modelo;
    var replacement = "<strong>" + cadena + "</strong>";
    var destacado;
    console.log("Resaltando: " + cadena);
    if(cadena.length > 0){
        destacado = remplazar.replace(new RegExp(cadena,"gi"), replacement);
    }

    return destacado;

  }
  