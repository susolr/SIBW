<?php
  include("bd.php");

  $id = $_GET['id'];
  $bd=new bd;
  switch ($id) {
      case 1:
        $palabras = $bd->getPalabrasProhibidas();
        echo json_encode($palabras);
        break;
      
      default:
        echo "patata";
        break;
  }
?> 