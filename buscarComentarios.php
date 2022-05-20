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
  $str = $_GET["str"];
  $comentarios= null;
  if ($user['tipo'] == 1 or $user['tipo'] == 3 ){
    $comentarios = $bd->buscarComentarios($str);
  }
  // echo($_GET["id"]);
  echo (json_encode($comentarios));
?>