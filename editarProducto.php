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
  $username = "susolr";
  $id = 0;

  
  if (isset($_GET['id'])){
    $id = $_GET['id'];
  }
  
  if (isset($_POST['modificar_producto'])) {

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $subtitulo = $_POST['subtitulo'];
    $descripcion = $_POST['descripcion'];

    if (empty($nombre)) { array_push($errors, "Nombre necesario"); }
    if (empty($subtitulo)) { array_push($errors, "Subtitulo necesario"); }
    if (empty($descripcion)) { array_push($errors, "Descripcion necesaria"); }

    if (count($errors) == 0) {

        $bd->editarProducto($id, $nombre, $subtitulo, $descripcion);

        header('location: listaProductos.php');
    }

  }

  $producto= $bd->getProducto($id);

  echo $twig->render('editar_producto.html', ['producto'=>$producto, 'errores' => $errors]);
?>