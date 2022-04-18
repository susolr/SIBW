<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");

  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  
  $id = $_GET['id'];
  $bd=new bd;
  $producto = $bd->getProducto($id);
  
  echo $twig->render('producto.html', ['producto' => $producto]);
?>
