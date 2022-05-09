<?php
  include("bd.php");
  require_once "/usr/local/lib/php/vendor/autoload.php";
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  session_start();

  // initializing variables
  $username = "";
  $errors = array();
  $bd= new bd;


  if (isset($_POST['insertar_producto'])) {
    $nombre = $_POST['nombre'];
    $subtitulo = $_POST['subtitulo'];
    $descripcion = $_POST['descripcion'];
    $img_p = $_POST['img-principal'];
    $img_s1 = $_POST['img-s1'];
    $img_s2 = $_POST['img-s2'];

    if (empty($nombre)) { array_push($errors, "Nombre necesario"); }
    if (empty($subtitulo)) { array_push($errors, "Subtitulo necesario"); }
    if (empty($descripcion)) { array_push($errors, "Descripcion necesaria"); }

    if (empty($img_p)) { array_push($errors, "Imagen principal necesaria"); }

    if (count($errors) == 0) {
        $bd->insertarProducto($nombre, $subtitulo, $descripcion, $img_p, $img_s1, $img_s2);
        header('location: listaProductos.php');
    }

  }

  echo $twig->render('insertarProducto.html', ['errores' => $errors]);
?>