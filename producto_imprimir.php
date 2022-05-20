<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  include("bd.php");
  session_start();
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  
  
  $id = $_GET['id'];
  $bd=new bd;
  $producto = $bd->getProducto2($id);
  
  echo $twig->render('producto_imprimir.html', ['producto' => $producto]);
?>
