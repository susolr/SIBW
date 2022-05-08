<?php
  // echo($_GET["id"]);
  // echo($idEv);
  $bd=new bd();

  $bd->borrarComentario($_GET["id"]);
  // echo($_GET["id"]);
  header("Location: /comments");
?>
