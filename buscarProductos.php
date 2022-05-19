<?php
  // echo($_GET["id"]);
  // echo($idEv);
  include("bd.php");
  require_once "/usr/local/lib/php/vendor/autoload.php";
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  $bd=new bd();
  if(isset($_SESSION['user'])){
    $username = $_SESSION['user']; // Almaceno el usuario
  }
  $user = $bd->encontrarUsuario($username);
  $str = $_GET["str"];
  $productos = $bd->buscarProductos($str, $user['tipo']);

  // echo($_GET["id"]);
  echo (json_encode($productos));
?>