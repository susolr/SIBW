<?php
  // echo($_GET["id"]);
  // echo($idEv);
  include("bd.php");
  require_once "/usr/local/lib/php/vendor/autoload.php";
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  $bd=new bd();

  $bd->insertarComentario($_POST["producto"],$_POST["autor"],$_POST["fecha"],$_POST["texto"]);
  // echo($_GET["id"]);
  header("Location: /listaComentarios.php");
?>
