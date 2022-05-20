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

    function getListaProductos(){
      
      $arr = [];
      $stmt = $this->mysqli->prepare("SELECT * FROM productos");
      $stmt->execute();
      $result = $stmt->get_result();

      while($row = $result->fetch_assoc()){
        $prod = array('id'=> $row['id'], 'nombre' => $row['nombre'], 'img_principal' => $row['img_principal'], 'subtitulo' => $row['subtitulo'], 'contenido' => $row['texto'], 'publicado' => $row['publicado']);
        $arr[] = $prod;
      }
      $stmt->close();
      return $arr;
    }

    function getProducto ($idPro){

      $stmt = $this->mysqli->prepare("SELECT nombre, subtitulo, texto, publicado FROM productos WHERE id = ? ");
      $stmt->bind_param("i", $idPro);
      $stmt->execute();
      $res = $stmt->get_result();
      $subtitulo = "Subtitulo no disponible";
      $contenido = "Contenido no disponible";
      $publicado = 0;
      if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $nombre = $row['nombre'];
        $contenido = $row['texto'];
        $subtitulo = $row['subtitulo'];
        $publicado =$row['publicado'];
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

      $producto = array('id' => $idPro, 'nombre' => $nombre, 'img_1' => $img_1, 'img_2' => $img_2, 'subtitulo' => $subtitulo, 'contenido' => $contenido, 'publicado' => $publicado);
      
      return $producto;

    }

    function buscarProductos($str,$tipo){
      if($tipo >= 2){
          $sql = "SELECT * FROM productos WHERE (nombre LIKE ? OR subtitulo LIKE ? OR texto LIKE ?)";
      }
      else{
          $sql = "SELECT * FROM productos WHERE (publicado = 1 AND (nombre LIKE ? OR subtitulo LIKE ? OR texto LIKE ?))";
      }
      $str = "%".$str."%";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("sss",$str,$str,$str);
      $stmt->execute();
      $result = $stmt->get_result();
      while($row = $result->fetch_assoc()){
        $prod = array('id'=> $row['id'], 'nombre' => $row['nombre'], 'img_principal' => $row['img_principal'], 'subtitulo' => $row['subtitulo'], 'contenido' => $row['texto'], 'publicado' => $row['publicado']);
        $arr[] = $prod;
      }
      $stmt->close();
      return $arr;
    }

    function borrarProducto($id){
      $this->mysqli->query("DELETE FROM imagenes WHERE producto=$id");
			$this->mysqli->query("DELETE FROM productos WHERE id=$id");
		}

    function insertarProducto($nombre, $subtitulo, $descripcion, $img_p, $img_1, $img_2){
      $this->mysqli->query("INSERT INTO productos(nombre, img_principal, subtitulo, texto, publicado) VALUES ('$nombre', '$img_p', '$subtitulo', '$descripcion', 1)");

      $res = $this->mysqli->query("SELECT id FROM productos WHERE nombre='$nombre' ORDER BY id DESC");
      $row = $res->fetch_assoc();
      $id = $row['id'];

      if (!empty($img_1)){
        $res = $this->mysqli->query("INSERT INTO `imagenes`(`producto`, `recurso`) VALUES ( $id ,'$img_1')");
      }

      if (!empty($img_2)){
        $res = $this->mysqli->query("INSERT INTO `imagenes`(`producto`, `recurso`) VALUES ( $id ,'$img_2')");
      }

    }

    function editarProducto($id, $nombre, $subtitulo, $descripcion, $publicado){
      $this->mysqli->query("UPDATE productos SET nombre='$nombre', subtitulo='$subtitulo', texto='$descripcion', publicado=$publicado WHERE id=$id");
    }

    function getListaEstados(){
      $res=$this->mysqli->query("SELECT * FROM estadoproducto");
      $arr = [];
      while($row = $res->fetch_assoc()){
        $arr[]= array('estado' => $row['estado'], 'id' => $row['id']);
      }
      return $arr;
    }


    //Palabras prohibidas

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
			$usuario = array('id' => 0,'username' => 'XXX', 'pass' => 'YYY', 'nombre' => 'Unknown', 'apellidos'=> 'apellidos', 'email' => 'prueba@gmail.com','tipo' => -1);

			//echo("SELECT * FROM usuarios WHERE nick='" . $username ."'");

			if ($res->num_rows > 0) {
	      $row = $res->fetch_assoc();
				$usuario= array('id' => $row['id'], 'username'=> $row['username'], 'pass'=>$row['pass'], 'nombre' => $row['nombre'], 'apellidos'=>$row['apellidos'], 'email' =>$row['email'],'tipo'=>$row['tipo']);
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

    function getListaUsuarios(){
        $res=$this->mysqli->query("SELECT * FROM usuarios");
        while($row = $res->fetch_assoc()){
          $arr[]=  array( 'username'=>$row['username'], 'nombre' => $row['nombre'], 'tipo' =>$row['tipo']);
        }
        return $arr;
    }

    function editarRol($username,$rol){
			$this->mysqli->query("UPDATE usuarios SET tipo=$rol WHERE username='$username'");
		}

    function numSuperusuarios(){
			$res = $this->mysqli->query("SELECT COUNT(*) FROM usuarios WHERE tipo=3");

			return $res;
		}

    function getListaTipos(){
      $res=$this->mysqli->query("SELECT * FROM tipousuario");
      $arr = [];
      while($row = $res->fetch_assoc()){
        $arr[]= array('tipo' => $row['tipo'], 'id' => $row['id']);
      }
      return $arr;
    }

    function getComentario($id){
      $producto = "";
      $autor="";
      $fecha="";
      $texto="";
      $idAutor = 0;
      $idPro = 0;
      $modificado = 0;

      $stmt = $this->mysqli->prepare("SELECT * FROM comentarios WHERE id= ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $res = $stmt->get_result();
      
      if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $fecha = $row['fecha'];
        $texto = $row['texto'];
        $idAutor = $row['autor'];
        $idPro = $row['producto'];
        $modificado = $row['modificado'];
      }
      $stmt->close();

      $stmt = $this->mysqli->prepare("SELECT * FROM usuarios WHERE id=?");
      $stmt->bind_param("i", $idAutor);
      $stmt->execute();
      $res = $stmt->get_result();
      
      if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $autor = $row['username'];
      }
      $stmt->close();

      $stmt = $this->mysqli->prepare("SELECT * FROM productos WHERE id=?");
      $stmt->bind_param("i", $idPro);
      $stmt->execute();
      $res = $stmt->get_result();
      
      if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $producto = $row['nombre'];
      }
      $stmt->close();

      $comentario = array('id' => $id, 'producto' => $producto, 'autor' => $autor, 'fecha' => $fecha, 'texto' => $texto, 'modificado' => $modificado);

      return $comentario;

    }

    function buscarComentarios($str){

      $sql = "SELECT * FROM comentarios WHERE (nombre LIKE ? OR subtitulo LIKE ? OR texto LIKE ?)";

      $str = "%".$str."%";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("sss",$str,$str,$str);
      $stmt->execute();
      $result = $stmt->get_result();
      while($row = $result->fetch_assoc()){
        $prod = array('id'=> $row['id'], 'nombre' => $row['nombre'], 'img_principal' => $row['img_principal'], 'subtitulo' => $row['subtitulo'], 'contenido' => $row['texto'], 'publicado' => $row['publicado']);
        $arr[] = $prod;
      }
      $stmt->close();
      return $arr;
    }

    function getListaComentarios(){
      $res=$this->mysqli->query("SELECT id FROM comentarios");
      while($row = $res->fetch_assoc()){
        $arr[]=  $this->getComentario($row['id']);
      }
      return $arr;
    }
    function borrarComentario($id){
			$res = $this->mysqli->query("DELETE FROM comentarios WHERE id=$id");
		}

    function editarComentario($id, $texto){
      $this->mysqli->query("UPDATE comentarios SET texto='$texto', modificado=1 WHERE id=$id");
    }

    function insertarComentario($producto, $autor, $texto){
      $this->mysqli->query("INSERT INTO comentarios(producto, autor, fecha, texto) VALUES ( $producto, $autor, SYSDATE(),'$texto');");
    }

    function getComentarios($idPro){
      $stmt = $this->mysqli->prepare("SELECT id FROM comentarios WHERE producto=?");
      $stmt->bind_param("i", $idPro);
      $stmt->execute();
      $res = $stmt->get_result();
      $arr = [];

      while($row = $res->fetch_assoc()){
        $arr[]=  $this->getComentario($row['id']);
      }
      return $arr;
      
    }
  }
?>
