<?php
  require_once "/usr/local/lib/php/vendor/autoload.php";
  //
  $loader = new \Twig\Loader\FilesystemLoader('templates');
  $twig = new \Twig\Environment($loader);
  include("bd.php");
  session_start();
  //require_once 'bdUsuarios.php';
  $bd=new bd();
  if(isset($_POST['log_user'])){
    //printf("hola");
    //if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nick = $_POST['luser'];
      $pass = $_POST['lpass'];
      // echo($nick . $pass);

      if ($bd->checkLogin($nick, $pass)) {
        session_start();

        $_SESSION['nickUsuario'] = $nick;  // guardo en la sesión el nick del usuario que se ha logueado
        // echo($nick);
      }

      header("Location: index.php");

      //exit();
    //}
  }

  echo $twig->render('login.html', []);
?>