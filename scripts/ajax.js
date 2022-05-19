$(document).ready(function() {
    searchbar.oninput = hacerPeticionAjax;  
    console.log("Preparando");  
  });
  
  function hacerPeticionAjax() {
      var str = $("#searchbar").val();
      console.log("Buscando: " + str);

    if(str.length === 0){
        $("#results").css("display", "none");
        $("#productos_list").css("display", "grid");
        console.log("Busqueda vacia. Mostrando todos los productos")
        return;
    }
      
    $.ajax({
        data: {str},
        url: 'buscarProductos.php',
        type: 'get',
        success: function(respuesta) {
          procesaRespuestaAjax(respuesta);
        }
    });
  }
  
  function procesaRespuestaAjax(respuesta) {
      res = "";
      console.log("Respuesta " + respuesta);
      for (i = 0 ; i < respuesta.length ; i++) {
          res += "<div class=panel> <div class=nombre>" + respuesta[i].nombre + "</div></div>";
      }
      console.log("Res " + res);
      $("#results").html(res);
      $("#results").css("display", "grid");
      $("#productos_list").css("display", "none");
  }
  