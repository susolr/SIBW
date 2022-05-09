<?php
  include("bd.php");
  require_once "/usr/local/lib/php/vendor/autoload.php";
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  session_start();

  // initializing variables
  $username = "";
  $errors = array();
  $bd= new bd;
  $username = "susolr";
  $id = 0;

  
  if (isset($_GET['id'])){
    $id = $_GET['id'];
  }
  
  if (isset($_POST['modificar_datos'])) {

    $texto = $_POST['texto'];
    $id = $_POST['id'];
    if (empty($texto)) { array_push($errors, "Text is required"); }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {

        $bd->editarComentario($id, $texto);

        header('location: listaComentarios.php');
    }

  }

  $comentario = $bd->getComentario(2);



  echo $twig->render('editar_comentario.html', ['comentario'=>$comentario]);
?>