<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  session_start();
  
  $bd=new bd;
  $id = 0;
  if (isset($_GET['id'])){
    $id = $_GET['id'];
  }
  $errors = array();

  if (isset($_POST['publicar_comentario'])){
    $autor = $_POST['autor'];
    $producto = $_POST['producto'];
    $texto = $_POST['coment'];
    $id = $producto;
    if (empty($texto)) { array_push($errors, "Text is required"); }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {

        $bd->insertarComentario($producto, $autor, $texto);
    }
  }

  $producto = $bd->getProducto($id);
  $user = $bd->encontrarUsuario("susolr");
  $comentarios = $bd->getComentarios($id);


  
  echo $twig->render('producto.html', ['user' => $user, 'producto' => $producto, 'comentarios' => $comentarios]);
?>
