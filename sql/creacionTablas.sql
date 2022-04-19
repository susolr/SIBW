CREATE TABLE productos(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  img_principal VARCHAR(100)
)

CREATE TABLE imagenes(
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto INT,
  recurso VARCHAR(100),
  FOREIGN KEY (producto) REFERENCES productos(id)
)

CREATE TABLE contenido(
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto INT,
  subtitulo VARCHAR(100),
  texto TEXT,
  FOREIGN KEY (producto) REFERENCES productos(id)
)

CREATE TABLE comentarios(
  id INT AUTO_INCREMENT PRIMARY KEY,
  producto INT,
  autor VARCHAR(100),
  fecha DATETIME,
  texto VARCHAR(1000),
  FOREIGN KEY (producto) REFERENCES productos(id)
)

CREATE TABLE palabrasprohibidas(
  id INT AUTO_INCREMENT PRIMARY KEY,
  palabra VARCHAR(100)
)





