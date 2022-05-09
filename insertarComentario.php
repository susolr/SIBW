<?php
  // echo($_GET["id"]);
  // echo($idEv);
  include("bd.php");
  $bd=new bd();
  $errors = array();

  if (isset($_POST['publicar_comentario'])) {

    $autor = $_POST['autor'];
    $producto = $_POST['producto'];
    $texto = $_POST['contenido'];
    if (empty($texto)) { array_push($errors, "Text is required"); }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {

        $bd->insertarComentario($producto, $autor, $texto);
    }
  }

  header('location: producto.php?id='.$producto);

?>
