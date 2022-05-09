<?php
  // echo($_GET["id"]);
  // echo($idEv);
  include("bd.php");
  require_once "/usr/local/lib/php/vendor/autoload.php";
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  $bd=new bd();

  $bd->borrarProducto($_GET["id"]);
  // echo($_GET["id"]);
  header("Location: /listaProductos.php");
?>
