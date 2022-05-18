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
  $username = "";
  if(isset($_SESSION['user'])){
    $username = $_SESSION['user']; // Almaceno el usuario
  }
  $user = $bd->encontrarUsuario($username);
  $id = 0;

  
  if (isset($_GET['id'])){
    $id = $_GET['id'];
  }
  
  if (isset($_POST['modificar_producto'])) {

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $subtitulo = $_POST['subtitulo'];
    $descripcion = $_POST['descripcion'];
    $publicado = $_POST['publicado'];

    if (empty($nombre)) { array_push($errors, "Nombre necesario"); }
    if (empty($subtitulo)) { array_push($errors, "Subtitulo necesario"); }
    if (empty($descripcion)) { array_push($errors, "Descripcion necesaria"); }

    if (count($errors) == 0) {

        $bd->editarProducto($id, $nombre, $subtitulo, $descripcion, $publicado);

        header('location: listaProductos.php');
    }

  }

  $producto= $bd->getProducto($id);
  $estados = $bd->getListaEstados();

  echo $twig->render('editar_producto.html', ['user' => $user, 'producto'=>$producto, 'errores' => $errors, 'estados' => $estados]);
?>