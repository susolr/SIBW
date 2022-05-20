<?php
  include("bd.php");
  $bd=new bd;
  session_start();
  $palabras = $bd->getPalabrasProhibidas();
  echo json_encode($palabras);
?> 