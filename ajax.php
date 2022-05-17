<?php
  function randomString() {
    $chars = 'abcdefghijklmnopqrstuvwxyz';
    $randstring = '';
    
    for ($i = 0 ; $i < 10 ; $i++) {
      $randstring .= $chars[rand(0, strlen($chars))];
    }
    
    return $randstring;
  }
  
  header('Content-Type: application/json');
  
  sleep(rand(2,6));
  
  $numElems = (int)$_GET['num'];
  
  $datos = array();
  
  for ($i = 0 ; $i < $numElems ; $i++) {
    array_push($datos, ['obj' => randomString(), "cant" => rand(1,9)]);
  }
  
  echo(json_encode($datos));
?>
