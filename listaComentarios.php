<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  session_start();

  $bd=new bd();
  $comments=$bd->getListaComentarios();
  if(isset($_SESSION['nickUsuario'])){
    $user=$bd->encontrarUsuario($_SESSION['nickUsuario']);
  }

  echo $twig->render('lista_comentarios.html', ['user'=>$user,'comentarios'=>$comments]);
?>
