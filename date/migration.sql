CREATE DATABASE inventario;

use inventario;

CREATE TABLE personal (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(60) NOT NULL,
  apellido_paterno VARCHAR(50) NOT NULL,
  apellido_materno VARCHAR(50) NOT NULL,
  puesto_cargo VARCHAR(60) NOT NULL,
  telefono BIGINT NOT NULL,
  email VARCHAR(80) NOT NULL,
  password LONGTEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ubicacion (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre_ubicacion VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE articulo (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre_articulo VARCHAR(100) NOT NULL,
  cantidad INT(11) NOT NULL,
  descripcion_articulo VARCHAR(255) NOT NULL,
  id_Ubicacion INT(11) UNSIGNED NOT NULL,
  id_Responsable INT(11) UNSIGNED NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_Ubicacion) REFERENCES ubicacion(id) 
  ON DELETE RESTRICT ON UPDATE RESTRICT,
  FOREIGN KEY (id_Responsable) REFERENCES personal(id)
  ON DELETE RESTRICT ON UPDATE RESTRICT
);

INSERT INTO `personal`(`nombre`, `apellido_paterno`, `apellido_materno`, `puesto_cargo`, `telefono`, `email`, `password`) VALUES ('Luis Alonzo','Bernal','Guardado','admin',4921425543,'luis@gmail.com','$2y$10$lHyHyVmiEhOG.KL8asNon.Lg8ncU.WKddR1Q1utk7quvhn67pCXS6');