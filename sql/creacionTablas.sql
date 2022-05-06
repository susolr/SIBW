CREATE TABLE productos(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  img_principal VARCHAR(100),
  subtitulo VARCHAR(100),
  texto TEXT
)

CREATE TABLE imagenes(
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto INT,
  recurso VARCHAR(100),
  FOREIGN KEY (producto) REFERENCES productos(id)
)

CREATE TABLE tipousuario(
  id INT AUTO_INCREMENT PRIMARY KEY,
  tipo VARCHAR(20) PRIMARY KEY,
  valor INT;
)

CREATE TABLE usuarios(
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(20),
  pass VARCHAR (200),
  nombre VARCHAR(100),
  apellidos VARCHAR(200),
  email VARCHAR(200),
  tipo INT REFERENCES tipousuario(id)
)

CREATE TABLE comentarios(
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto INT,
  autor VARCHAR(100),
  fecha DATETIME,
  texto TEXT,
  FOREIGN KEY (producto) REFERENCES productos(id)
)

CREATE TABLE palabrasprohibidas(
  id INT AUTO_INCREMENT PRIMARY KEY,
  palabra VARCHAR(100)
)





