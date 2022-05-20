<?php
  // echo($_GET["id"]);
  // echo($idEv);
  include("bd.php");
  require_once "/usr/local/lib/php/vendor/autoload.php";
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  $bd=new bd();
  session_start();
  if(isset($_SESSION['user'])){
    $username = $_SESSION['user']; // Almaceno el usuario
  }
  $user = $bd->encontrarUsuario($username);
  if($user['tipo'] >= 2){
    $bd->borrarProducto($_GET["id"]);
  }
  // echo($_GET["id"]);
  header("Location: /listaProductos.php");
?>
