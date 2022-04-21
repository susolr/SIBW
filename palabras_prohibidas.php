<?php
  include("bd.php");
  $bd=new bd;
  $palabras = $bd->getPalabrasProhibidas();
  echo json_encode($palabras);
?> 