<?php
  include("bd.php");
  $bd=new bd;
  $palabras = $bd->getComentarios($_GET["id"]);
  echo json_encode($palabras);
?> 