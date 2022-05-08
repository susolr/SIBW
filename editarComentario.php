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

  $user = $bd->getComentario($id);

  if (isset($_POST['modificar_datos'])) {

    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];

    if (empty($nombre)) { array_push($errors, "Name is required"); }
    if (empty($username)) { array_push($errors, "Apellidos is required"); }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Correo inválido");
    }


    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {

        $bd->modificarDatosUsuario($username, $nombre, $apellidos, $email);

        header('location: listaComentarios.php');
    }

  }

  echo $twig->render('editar_comentario.html', ['user'=>$user]);
?>