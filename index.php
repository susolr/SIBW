<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  $bd=new bd;

  $lista = $bd->getListaProductos();
  
  echo $twig->render('portada.html', ['productos'=>$lista]);
?>
