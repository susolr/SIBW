<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  session_start();

  //$username = $_SESSION['user'];
  $username = "";
  if(isset($_SESSION['user'])){
    $username = $_SESSION['user']; // Almaceno el usuario
  }

  

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  $bd=new bd;

  $user = $bd->encontrarUsuario($username);

  $lista = $bd->getListaProductos();
  
  echo $twig->render('portada.html', ['user' => $user, 'productos'=>$lista]);
?>
