-- ==========================================================
-- BASE DE DATOS CARTAS - tabla jugador
-- Importar desde phpMyAdmin (pestaña Importar) o pegar en la pestaña SQL
-- ==========================================================

CREATE DATABASE IF NOT EXISTS cartas
  DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;

USE cartas;

-- Estructura de la tabla jugador
CREATE TABLE IF NOT EXISTS jugador (
  nombre VARCHAR(25) NOT NULL,
  login  VARCHAR(15) NOT NULL,
  clave  VARCHAR(40) NOT NULL,
  puntos INT(11) NOT NULL DEFAULT 0,
  extra  INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (login)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- Datos de ejemplo (los del material del examen, con puntos y extra a 0)
INSERT INTO jugador (nombre, login, clave, puntos, extra) VALUES
('Benjamin',         'Benja',      '123', 0, 0),
('Guille',           'guillermo',  '123', 0, 0),
('Irene Adler',      'IreneAdler', '123', 0, 0),
('Luison',           'Luison',     '123', 0, 0),
('Luisa',            'mluisaoa',   '123', 0, 0),
('Victor Rubio',     'victorun',   '123', 0, 0),
('Yolanda Iglesias', 'yolandais',  '123', 0, 0);
