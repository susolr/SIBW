<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  session_start();

  $bd=new bd();
  $productos=$bd->getListaProductos();
  $user=$bd->encontrarUsuario("susolr");

  echo $twig->render('lista_productos.html', ['user'=>$user,'productos'=>$productos]);
?>
