-- =====================================================
-- Script SQL para el ejercicio 05 - CRUD de PRODUCTOS
-- Tema 5 - DWES
-- =====================================================

-- Crear la base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS test CHARACTER SET utf8 COLLATE utf8_general_ci;

USE test;

-- Eliminar la tabla si ya existe
DROP TABLE IF EXISTS PRODUCTOS;

-- Crear la tabla PRODUCTOS
CREATE TABLE PRODUCTOS (
    ref         VARCHAR(20)    NOT NULL PRIMARY KEY,
    nombre      VARCHAR(100)   NOT NULL,
    descripcion VARCHAR(255),
    precio      DECIMAL(10,2)  NOT NULL DEFAULT 0.00,
    categoria   ENUM('electronica','ropa','alimentacion','hogar','deporte') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Datos de prueba
INSERT INTO PRODUCTOS (ref, nombre, descripcion, precio, categoria) VALUES
    ('ELEC-001', 'Smartphone Galaxy',   'Teléfono móvil 128GB',           499.99, 'electronica'),
    ('ELEC-002', 'Auriculares BT',      'Auriculares inalámbricos',        79.95, 'electronica'),
    ('ROPA-001', 'Camiseta básica',     'Camiseta 100% algodón talla M',   12.50, 'ropa'),
    ('ALIM-001', 'Aceite de oliva 1L',  'Aceite de oliva virgen extra',     8.75, 'alimentacion'),
    ('HOGAR-001','Lámpara de mesa',     'Lámpara LED táctil regulable',    34.00, 'hogar'),
    ('DEP-001',  'Pelota de fútbol',    'Pelota oficial talla 5',          25.00, 'deporte');

