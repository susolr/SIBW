CREATE TABLE estadoproducto(
  id INT PRIMARY KEY,
  estado VARCHAR(20)
)
CREATE TABLE productos(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  img_principal VARCHAR(100),
  subtitulo VARCHAR(100),
  texto TEXT,
  publicado INT REFERENCES estadoproducto(id)
)

CREATE TABLE imagenes(
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto INT,
  recurso VARCHAR(100),
  FOREIGN KEY (producto) REFERENCES productos(id)
)

CREATE TABLE tipousuario(
  id INT PRIMARY KEY,
  tipo VARCHAR(20),
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
  autor INT,
  fecha DATETIME,
  texto TEXT,
  modificado INT DEFAULT 0,
  FOREIGN KEY (producto) REFERENCES productos(id),
  FOREIGN KEY (autor) REFERENCES usuarios(id)
)

CREATE TABLE palabrasprohibidas(
  id INT AUTO_INCREMENT PRIMARY KEY,
  palabra VARCHAR(100)
)





