<?php
include("bd.php");
require_once "/usr/local/lib/php/vendor/autoload.php";
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
  session_start();

  $bd=new bd();
  $usuarios=$bd->getListaUsuarios();
  $username = "susolr";
  $user = $bd->encontrarUsuario($username);
  $tipos = $bd->getListaTipos();

  if(isset($_POST['button_us'])){
      $usuario = $_POST['nick_us'];
      $rol = $_POST['operacion'];
      $old_tipo = $_POST['old_tipo'];
      //echo("Rol:".$rol);

      if(($bd->numSuperusuarios()>1 && $rol!=3 ) || $rol==3 || $old_tipo!=3){
        $bd->editarRol($usuario,$rol);
        header('location: index.php');
      }
      // $bd->editarRol($usuario,$rol);
			// header("Refresh:0");
  }

  echo $twig->render('adminUsers.html', ['usuario' => $user,'users'=>$usuarios, 'tipos' => $tipos]);
?>
