<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  session_start();

  $bd=new bd();
  $productos=$bd->getListaProductos();
  $username = "";
  if(isset($_SESSION['user'])){
    $username = $_SESSION['user']; // Almaceno el usuario
  }
  $user = $bd->encontrarUsuario($username);
  $estados = $bd->getListaEstados();

  echo $twig->render('lista_productos.html', ['user'=>$user,'productos'=>$productos, 'estados' => $estados]);
?>
