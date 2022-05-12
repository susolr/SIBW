<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  session_start();

  $bd=new bd();
  $comments=$bd->getListaComentarios();
  $username = "";
  if(isset($_SESSION['user'])){
    $username = $_SESSION['user']; // Almaceno el usuario
  }
  $user = $bd->encontrarUsuario($username);

  echo $twig->render('lista_comentarios.html', ['user'=>$user,'comentarios'=>$comments]);
?>
