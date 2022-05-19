$(document).ready(function() {
    searchbar.onkeyup = hacerPeticionAjax;    
  });
  
  function hacerPeticionAjax() {
      var str = $("#searchbar").val();

    if(str.length == 0){
        $("#results").css("display", "none");
        $("")
        return;
    }
      
    $.ajax({
        data: {str},
        url: 'buscarProductos.php',
        type: 'get',
        success: function(respuesta) {
          procesaRespuestaAjax(respuesta);
          $("#mensaje").hide();
        }
    });
  }
  
  function procesaRespuestaAjax(respuesta) {
      res = "";
      
      for (i = 0 ; i < respuesta.length ; i++) {
          res += "<tr><td>" + respuesta[i].obj + "</td><td>" + respuesta[i].cant + "</td></tr>\n";
      }
      
      $("#tabla > tbody").html(res);
  }
  