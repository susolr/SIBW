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


  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $subtitulo = $_POST['subtitulo'];
    $descripcion = $_POST['descripcion'];
    //$img_pn = $_POST['img-principal'];
    //$img_s1n = $_POST['img-s1'];
    //$img_s2n = $_POST['img-s2'];

    if (empty($nombre)) { array_push($errors, "Nombre necesario"); }
    if (empty($subtitulo)) { array_push($errors, "Subtitulo necesario"); }
    if (empty($descripcion)) { array_push($errors, "Descripcion necesaria"); }

    if(isset($_FILES['img-principal'])){
      $file_name = $_FILES['img-principal']['name'];
      $file_name = str_replace(' ', '', $file_name);
      $file_tmp = $_FILES['img-principal']['tmp_name'];
      $file_ext = strtolower(end(explode('.',$_FILES['img-principal']['name'])));

      $extensions = array("jpeg","jpg","png","svg");

      if(!in_array($file_ext,$extensions)){
          array_push($errors, "Invalid file extension img-principal". $file_ext );
      }
      
      $img_p = 'images/' . $file_name;
      move_uploaded_file($file_tmp,$_SERVER['DOCUMENT_ROOT'].'/'.$img_p);
    }
    else{
      array_push($errors, "Imagen principal necesaria");
    }

    if(isset($_FILES['img-s1'])){
      $file_name = $_FILES['img-s1']['name'];
      $file_name = str_replace(' ', '', $file_name);
      $file_tmp = $_FILES['img-s1']['tmp_name'];
      $file_ext = strtolower(end(explode('.',$_FILES['img-s1']['name'])));

      $extensions = array("jpeg","jpg","png","svg");

      if(!in_array($file_ext,$extensions)){
          array_push($errors, "Invalid file extension s1");
      }
      
      $img_s1 = 'images/' . $file_name;
      move_uploaded_file($file_tmp,$_SERVER['DOCUMENT_ROOT'].'/'.$img_s1);
    }
    else{
      array_push($errors, "Imagen secundaria 1");
    }

    if(isset($_FILES['img-s2'])){
      $file_name = $_FILES['img-s2']['name'];
      $file_name = str_replace(' ', '', $file_name);
      $file_tmp = $_FILES['img-s2']['tmp_name'];
      $file_ext = strtolower(end(explode('.',$_FILES['img-s2']['name'])));

      $extensions = array("jpeg","jpg","png","svg");

      if(!in_array($file_ext,$extensions)){
          array_push($errors, "Invalid file extension s2");
      }
      
      $img_s2 = 'images/' . $file_name;
      move_uploaded_file($file_tmp,$_SERVER['DOCUMENT_ROOT'].'/'.$img_s2);
    }
    else{
      array_push($errors, "Imagen secundaria 2");
    }

    if (count($errors) == 0) {
        $bd->insertarProducto($nombre, $subtitulo, $descripcion, $img_p, $img_s1, $img_s2);
        header('location: listaProductos.php');
    }

  }

  echo $twig->render('insertarProducto.html', ['user' => $user, 'errores' => $errors]);
?>