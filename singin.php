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


  if (isset($_POST['reg_user'])) {
  $username = $_POST['luser'];
  $password_1 = $_POST['lpass1'];
  $password_2 = $_POST['lpass2'];
  $nombre = $_POST['nombre'];
  $apellidos = $_POST['apellidos'];
  $email = $_POST['email'];

  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  if (empty($nombre)) { array_push($errors, "Name is required"); }
  if (empty($username)) { array_push($errors, "Apellidos is required"); }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    array_push($errors, "Correo inválido");
  }


  $user=$bd->encontrarUsuario($username);
  //$user = mysqli_fetch_assoc($result);

  if ($user['nick']!='XXX') { // if user exists
    if ($user['nick'] === $username) {
      array_push($errors, "Username already exists");
    }
  }


  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database


  	$bd->signIn($username,$password, $nombre, $apellidos, $email);

  	$_SESSION['user'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: login.php');
  }
}

  echo $twig->render('signIn.html', []);
?>