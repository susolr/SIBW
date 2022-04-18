<?php
	// crear objecto bd con un constructor con las funciones

	class bd {
		public $mysqli;

		function __construct(){
			$this->conectar();
		}
		function conectar(){
		$this->mysqli = new mysqli("mysql", "laura", "lolacaracola", "SIBW");
	    	if ($this->mysqli->connect_errno) {
	      		echo ("Fallo al conectar: " . $this->mysqli->connect_error);
	    	}
	    	return $this->mysqli;
		}

	  function getEvento($idEv) {
			//printf(is_null($mysqli));
	    $res = $this->mysqli->query("SELECT nombre, fecha, contenido,imagen, banner FROM eventos WHERE id=" . $idEv);

	    $evento = array('nombre' => 'XXX', 'fecha' => 'YYY', 'contenido' => '','imagen' => 'IMG', 'banner' => 'BANNER', 'publicado' => 'false');

	    if ($res->num_rows > 0) {
	      $row = $res->fetch_assoc();

	      $evento = array('nombre' => $row['nombre'], 'fecha' => $row['fecha'],'contenido'=>$row['contenido'], 'imagen' => $row['imagen'], 'banner' => $row['banner'], 'publicado' => $row['publicado']);
	    }

	    return $evento;
	  }

	  function getBannedWords(){
	    	$res = $this->mysqli->query("SELECT word FROM banned_words");
	  	return $res;
	  }

		function signIn($username, $password){
			// echo ($password);
			$res = $this->mysqli->query("INSERT INTO usuarios (nick, password, tipo)
	  			  VALUES('$username', '$password','registrado')");
	  	return $res;
		}

		function encontrarUsuario($username){
			$res = $this->mysqli->query("SELECT * FROM usuarios WHERE nick='" . $username ."'");
			$usuario = array('nick' => 'XXX', 'pass' => 'YYY', 'rol' => 'ROL');

			//echo("SELECT * FROM usuarios WHERE nick='" . $username ."'");

			if ($res->num_rows > 0) {
	      $row = $res->fetch_assoc();
				$usuario= array('nick'=> $row['nick'], 'pass'=>$row['password'], 'rol'=>$row['tipo']);
			}
			return $usuario;
		}

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

		function cambiarNick($nick,$new_nick){
			$res = $this->mysqli->query("UPDATE usuarios SET nick='" . $new_nick . "' WHERE nick='" . $nick ."'");
			// $usuario = array('nick' => 'XXX', 'pass' => 'YYY', 'rol' => 'ROL');
		}
		function cambiarPass($pass,$new_pass){
			$res = $this->mysqli->query("UPDATE usuarios SET password='" . $new_pass . "' WHERE password='" . $pass ."'");
		}

		function getAllComments(){
			$res=$this->mysqli->query("SELECT * FROM comentarios");
			// $comentarios= array('id'=>'','idpost'=> '', 'autor'=>'', 'comentario'=>'', 'fecha'=>'');
			// if ($res->num_rows > 0) {
	    //   $row = $res->fetch_assoc();
			// 	$comentarios= array('id'=>$row['id'],'idpost'=> $row['idpost'], 'autor'=>$row['autor'], 'comentario'=>$row['comentario'], 'fecha'=>$row['fecha']);
			// }
			return $res;
		}
		function getAllUsers(){
			$res=$this->mysqli->query("SELECT * FROM usuarios");

			return $res;
		}

		function getComments($idEv){
			$res = $this->mysqli->query("SELECT * FROM comentarios WHERE idpost='" . $idEv ."'");
			// $row = $res->fetch_assoc();
			return $res;
		}
		function insertarComentario($autor,$texto,$idEv){
			$this->mysqli->query("INSERT INTO comentarios(idpost,autor,comentario, fecha)
	  			  VALUES($idEv,'$autor', '$texto',now())");
		}
		function editarComentario($id,$texto){
			$res = $this->mysqli->query("UPDATE comentarios SET comentario='" . $texto . "' WHERE id='" . $id ."'");
		}
		function borrarComentario($id){
			$res = $this->mysqli->query("DELETE FROM comentarios WHERE id='" . $id ."'");
		}

		function getEventos(){
			$res = $this->mysqli->query("SELECT * FROM eventos");

			return $res;
		}

		function borrarEvento($id){
			$this->mysqli->query("DELETE FROM eventos WHERE id='" . $id ."'");
		}
		function insertarEvento($nombre,$date,$contenido){
			$this->mysqli->query("INSERT INTO eventos(nombre,fecha,contenido)
	  			  VALUES('$nombre','$fecha', '$contenido')");
			// echo("hola");
		}
		function editarRol($nick,$rol){
			$this->mysqli->query("UPDATE usuarios SET tipo='" . $rol . "' WHERE nick='" . $nick ."'");
		}
		function numSuperusuarios(){
			$res = $this->mysqli->query("SELECT COUNT(*) FROM usuarios WHERE tipo='super'");

			return $res;
		}

		function publicarEvento($id){
			$res = $this->mysqli->query("UPDATE eventos SET publicado=true WHERE id='" . $id ."'");
		}
		function despublicarEvento($id){
			$res = $this->mysqli->query("UPDATE eventos SET publicado=false WHERE id='" . $id ."'");
		}

		function getSearch($text){
			// $res = $this->mysqli->query("SELECT id,nombre,imagen FROM eventos where nombre= '%".$text."%' order by nombre asc limit 5");
			$res = $this->mysqli->query("SELECT id,nombre,imagen FROM eventos where nombre like '%$text%' order by nombre asc");
	    $evento = array('id' => 'XXX', 'nombre' => 'YYY', 'imagen' => 'IMG');
			$search_arr = array();

			while($fetch = mysqli_fetch_assoc($res)){
			 $id = $fetch['id'];
			 $name = $fetch['nombre'];
			 $imagen=$fetch['imagen'];

			 // var_dump($id);
			 $search_arr[] = array("id" => $id, "nombre" => $name, 'imagen'=>$imagen);
	 		}
			// echo ($search_arr);
	    return $search_arr;
		}

		function getSearchPublicados($text){
			// $res = $this->mysqli->query("SELECT id,nombre,imagen FROM eventos where nombre= '%".$text."%' order by nombre asc limit 5");
			$res = $this->mysqli->query("SELECT id,nombre,imagen FROM eventos where nombre like '%$text%' and publicado like '1' order by nombre asc");
	    $evento = array('id' => 'XXX', 'nombre' => 'YYY', 'imagen' => 'IMG');
			$search_arr = array();

			while($fetch = mysqli_fetch_assoc($res)){
			 $id = $fetch['id'];
			 $name = $fetch['nombre'];
			 $imagen=$fetch['imagen'];

			 // var_dump($id);
			 $search_arr[] = array("id" => $id, "nombre" => $name, 'imagen'=>$imagen);
	 		}
			// echo ($search_arr);
	    return $search_arr;
		}

	}

?>
