-- ============================================================
-- Script SQL - Ejercicio 07 - Relaciones N:M
-- Entidades: PERSONA, PAIS, AFICION
-- Relaciones: nace (N:1), vive (N:1), GUSTO (N:M), ODIO (N:M)
-- ============================================================

CREATE DATABASE IF NOT EXISTS test CHARACTER SET utf8 COLLATE utf8_general_ci;
USE test;

-- ---- Tablas base ----

DROP TABLE IF EXISTS GUSTO;
DROP TABLE IF EXISTS ODIO;
DROP TABLE IF EXISTS PERSONA;
DROP TABLE IF EXISTS AFICION;
DROP TABLE IF EXISTS PAIS;

CREATE TABLE PAIS (
    id_pais  INT AUTO_INCREMENT PRIMARY KEY,
    nombre   VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE AFICION (
    id_aficion INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE PERSONA (
    id_persona   INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(100) NOT NULL,
    apellido     VARCHAR(100) NOT NULL,
    id_pais_nace INT NOT NULL,
    id_pais_vive INT,
    FOREIGN KEY (id_pais_nace) REFERENCES PAIS(id_pais),
    FOREIGN KEY (id_pais_vive) REFERENCES PAIS(id_pais)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---- Tablas N:M ----

CREATE TABLE GUSTO (
    id_persona INT NOT NULL,
    id_aficion INT NOT NULL,
    PRIMARY KEY (id_persona, id_aficion),
    FOREIGN KEY (id_persona) REFERENCES PERSONA(id_persona) ON DELETE CASCADE,
    FOREIGN KEY (id_aficion) REFERENCES AFICION(id_aficion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE ODIO (
    id_persona INT NOT NULL,
    id_aficion INT NOT NULL,
    PRIMARY KEY (id_persona, id_aficion),
    FOREIGN KEY (id_persona) REFERENCES PERSONA(id_persona) ON DELETE CASCADE,
    FOREIGN KEY (id_aficion) REFERENCES AFICION(id_aficion) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ---- Datos de prueba ----

INSERT INTO PAIS (nombre) VALUES
    ('España'), ('Francia'), ('Alemania'), ('Italia'), ('Argentina'), ('México');

INSERT INTO AFICION (nombre) VALUES
    ('Fútbol'), ('Lectura'), ('Música'), ('Cocina'), ('Senderismo'),
    ('Fotografía'), ('Videojuegos'), ('Pintura');

INSERT INTO PERSONA (nombre, apellido, id_pais_nace, id_pais_vive) VALUES
    ('Ana',   'García',   1, 1),
    ('Pierre','Dupont',   2, 1),
    ('Klaus', 'Müller',   3, 2);

-- Gustos
INSERT INTO GUSTO VALUES (1,1),(1,2),(2,3),(2,4),(3,5),(3,6);
-- Odios
INSERT INTO ODIO  VALUES (1,7),(1,8),(2,1),(3,2),(3,7);
