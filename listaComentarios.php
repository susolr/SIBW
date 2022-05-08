<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  session_start();

  $bd=new bd();
  $comments=$bd->getListaComentarios();
  $user=$bd->encontrarUsuario("susolr");

  echo $twig->render('lista_comentarios.html', ['user'=>$user,'comentarios'=>$comments]);
?>
