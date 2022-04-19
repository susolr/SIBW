<?php
  class bd {
    public $mysqli;

    function __construct(){
      $this->createConnection();
    }
    function createConnection(){
      $this->mysqli = new mysqli("mysql", "jesuslr", "150599jlr", "SIBW");
      if ($this->mysqli->connect_errno) {
        echo ("Fallo al conectar: " . $this->mysqli->connect_error);
      }

      return $this->mysqli;
    }

    function prueba(){

      $mysqli = new mysqli("mysql", "coronavirus", "covid19", "SIBW");
      if ($mysqli->connect_errno) {
        echo ("Fallo al conectar: " . $mysqli->connect_error);
      }

      $arr = [];
      $stmt = $mysqli->prepare("SELECT nombre, favorite_color, age FROM myTable WHERE name = ?");
      $stmt->bind_param("s", $_POST['name']);
      $stmt->execute();
      $result = $stmt->get_result();
      while($row = $result->fetch_row()) {
        $arr[] = $row;
      }

      $stmt->close();

    }

    function getListaProductos(){
      
      $arr = [];
      $stmt = $this->mysqli->prepare("SELECT id, nombre, img_principal FROM productos");
      $stmt->execute();
      $result = $stmt->get_result();

      while($row = $result->fetch_assoc()){
        $prod = array('id'=> $row['id'], 'nombre' => $row['nombre'], 'img_principal' => $row['img_principal']);
        $arr[] = $prod;
      }
      $stmt->close();
      return $arr;
    }

    function getProducto ($idPro){

      $stmt = $this->mysqli->prepare("SELECT nombre FROM productos WHERE id = ? ");
      $stmt->bind_param("i", $idPro);
      $stmt->execute();
      $res = $stmt->get_result();
      $row = $res->fetch_assoc();
      $nombre = $row['nombre'];
      $stmt->close();

      $stmt = $this->mysqli->prepare("SELECT recurso FROM imagenes WHERE producto = ? ");
      $stmt->bind_param("i", $idPro);
      $stmt->execute();
      $res = $stmt->get_result();

      $img_1 = "images/error.png";
      $img_2 = $img_1;

      if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $img_1 = $row['recurso'];
        if ($res->num_rows > 1){
          $row = $res->fetch_assoc();
          $img_2 = $row['recurso'];
        }
        else {
          $img_2 = $img_1;
        }
        
      }

      $stmt->close();

      $stmt = $this->mysqli->prepare("SELECT subtitulo, texto FROM contenido WHERE producto = ? ");
      $stmt->bind_param("i", $idPro);
      $stmt->execute();
      $res = $stmt->get_result();
      $subtitulo = "Subtitulo no disponible";
      $contenido = "Contenido no disponible";
      if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $contenido = $row['texto'];
        $subtitulo = $row['subtitulo'];
      }

      $stmt->close();

      $producto = array('id' => $idPro, 'nombre' => $nombre, 'img_1' => $img_1, 'img_2' => $img_2, 'subtitulo' => $subtitulo, 'contenido' => $contenido);
      
      return $producto;

    }

    function getProducto2 ($idPro){

      $stmt = $this->mysqli->prepare("SELECT nombre FROM productos WHERE id = ? ");
      $stmt->bind_param("i", $idPro);
      $stmt->execute();
      $res = $stmt->get_result();
      $row = $res->fetch_assoc();
      $nombre = $row['nombre'];
      $stmt->close();

      $producto = array('id' => $idPro, 'nombre' => $nombre);
      
      return $producto;

    }

    function getPalabrasProhibidas(){
	    	$res = $this->mysqli->query("SELECT palabra FROM palabrasprohibidas");
	  	return $res;
    }
  }
?>
