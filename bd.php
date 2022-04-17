<?php

  function getListaProductos(){

    $mysqli = new mysqli("mysql", "coronavirus", "covid19", "SIBW");
    if ($mysqli->connect_errno) {
      echo ("Fallo al conectar: " . $mysqli->connect_error);
    }

    $arr = [];
    $stmt = $mysqli->prepare("SELECT location, favorite_color, age FROM myTable WHERE name = ?");
    $stmt->bind_param("s", $_POST['name']);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_row()) {
      $arr[] = $row;
    }

    $stmt->close();

  }

  function getProducto ($idPro){

    $mysqli = new mysqli("mysql", "coronavirus", "covid19", "SIBW");
    if ($mysqli->connect_errno) {
      echo ("Fallo al conectar: " . $mysqli->connect_error);
    }

    $res = $mysqli->query("SELECT nombre, lugar FROM productos WHERE id=" . $idPro);
    
    $evento = array('nombre' => 'XXX', 'lugar' => 'YYY');
    
    if ($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $evento = array('nombre' => $row['nombre'], 'lugar' => $row['lugar']);
    }
    
    return $evento;

  }

  function getPalabrasProhibidas(){
    
  }

  function getEvento($idEv) {
  
    $mysqli = new mysqli("mysql", "coronavirus", "covid19", "SIBW");
    if ($mysqli->connect_errno) {
      echo ("Fallo al conectar: " . $mysqli->connect_error);
    }

    $res = $mysqli->query("SELECT nombre, lugar FROM eventos WHERE id=" . $idEv);
    
    $evento = array('nombre' => 'XXX', 'lugar' => 'YYY');
    
    if ($res->num_rows > 0) {
      $row = $res->fetch_assoc();
      
      $evento = array('nombre' => $row['nombre'], 'lugar' => $row['lugar']);
    }
    
    return $evento;
  }
?>
