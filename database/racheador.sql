-- ============================================================
-- Base de datos del proyecto "Racheador"
-- MySQL / MariaDB (compatible con XAMPP)
-- ============================================================

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS racheador
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE racheador;

-- ------------------------------------------------------------
-- Tabla: usuarios
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    clave VARCHAR(255) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: rachas
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS rachas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE NOT NULL,
    fecha_ultimo_reset DATE NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_rachas_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Tabla: racha_logs
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS racha_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    racha_id INT NOT NULL,
    fecha DATE NOT NULL,
    UNIQUE KEY uq_log_por_dia (racha_id, fecha),
    CONSTRAINT fk_logs_racha
        FOREIGN KEY (racha_id) REFERENCES rachas (id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;