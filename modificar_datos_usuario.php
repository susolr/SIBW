<?php
  include("bd.php");
  require_once "/usr/local/lib/php/vendor/autoload.php";
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  session_start();

  // initializing variables
  $username = "";
  $bd= new bd;
  $username = $_SESSION['user'];

  $user = $bd->encontrarUsuario($username);

  if (isset($_POST['modificar_datos'])) {

    //$bd->signIn($username,$password, $nombre, $apellidos, $email);

    header('location: index.php');
  }

  echo $twig->render('modificar_datos_usuario.html', ['user'=>$user]);
?>