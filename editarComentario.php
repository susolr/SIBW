<?php
  include("bd.php");
  require_once "/usr/local/lib/php/vendor/autoload.php";
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  session_start();

  // initializing variables

  $errors = array();
  $bd= new bd;
  $username = "";
  if(isset($_SESSION['user'])){
    $username = $_SESSION['user']; // Almaceno el usuario
  }
  $user = $bd->encontrarUsuario($username);
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

  $comentario = $bd->getComentario($id);



  echo $twig->render('editar_comentario.html', ['user' => $user, 'comentario'=>$comentario]);
?>