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

      $stmt = $this->mysqli->prepare("SELECT nombre, subtitulo, texto FROM productos WHERE id = ? ");
      $stmt->bind_param("i", $idPro);
      $stmt->execute();
      $res = $stmt->get_result();
      $subtitulo = "Subtitulo no disponible";
      $contenido = "Contenido no disponible";
      if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $nombre = $row['nombre'];
        $contenido = $row['texto'];
        $subtitulo = $row['subtitulo'];
      }
      
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

      $producto = array('id' => $idPro, 'nombre' => $nombre, 'img_1' => $img_1, 'img_2' => $img_2, 'subtitulo' => $subtitulo, 'contenido' => $contenido);
      
      return $producto;

    }

    function getPalabrasProhibidas(){
	    $res = $this->mysqli->query("SELECT palabra FROM palabrasprohibidas");
      $arr = [];
      while($row = $res->fetch_assoc()){
        $arr[]= $row['palabra'];
      }

	  	return $arr;
    }

    //Gestion de usuarios
    function checkLogin($username, $password){
			$userBD=$this->encontrarUsuario($username);
			//echo strlen($userBD['nick']);
			$hash = $userBD['pass'];
			// printf(strlen($hash));
			//echo $userBD['pass'];
			if(password_verify($password, $hash)){
			//if(password_verify($password, $hash)){
				// printf("Lo he conseguio");
				return true;
			} else{
				// printf("Acho");
				return false;
			}

		}

    function encontrarUsuario($username){
			$res = $this->mysqli->query("SELECT * FROM usuarios WHERE username='" . $username ."'");
			$usuario = array('username' => 'XXX', 'pass' => 'YYY', 'nombre' => 'Unknown', 'apellidos'=> 'apellidos', 'email' => 'prueba@gmail.com','tipo' => 'ROL');

			//echo("SELECT * FROM usuarios WHERE nick='" . $username ."'");

			if ($res->num_rows > 0) {
	      $row = $res->fetch_assoc();
				$usuario= array('username'=> $row['username'], 'pass'=>$row['pass'], 'nombre' => $row['nombre'], 'apellidos'=>$row['apellidos'], 'email' =>$row['email'],'tipo'=>$row['tipo']);
			}
			return $usuario;
		}

    function signIn($username, $password, $nombre, $apellidos, $email){
			// echo ($password);
      
			$res = $this->mysqli->query("INSERT INTO usuarios (username, pass, nombre, apellidos, email, tipo)
	  			  VALUES('$username', '$password', '$nombre','$apellidos', '$email',0)");
	  	return $res;
		}

    function modificarDatosUsuario($username, $nombre, $apellidos, $email){
      
			$res = $this->mysqli->query("UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', email='$email' WHERE username='$username'");
	  	return $res;
		}
  }
?>
