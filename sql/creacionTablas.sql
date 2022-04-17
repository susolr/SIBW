CREATE TABLE productos(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  img_principal VARCHAR(100)
)

CREATE TABLE imagenes(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  img_principal VARCHAR(100)
)

CREATE TABLE contenido(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  img_principal VARCHAR(100)
)

CREATE TABLE comentarios(
  id INT AUTO_INCREMENT PRIMARY KEY,
  autor VARCHAR(100),
  fecha DATETIME,
  texto VARCHAR(1000)
)

CREATE TABLE palabrasprohibidas(
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  img_principal VARCHAR(100)
)





