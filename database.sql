-- =====================================================
-- SISTEMA WEB DE ACUARISMO
-- Base de datos completa
-- =====================================================

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS acuario_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE acuario_db;

-- =====================================================
-- TABLA: roles
-- =====================================================
CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL COMMENT 'admin, usuario',
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO roles (name, description) VALUES 
('admin', 'Administrador del sistema'),
('usuario', 'Usuario regular');

-- =====================================================
-- TABLA: users
-- =====================================================
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    avatar_path VARCHAR(255),
    bio TEXT,
    role_id INT NOT NULL DEFAULT 2,
    email_verified BOOLEAN DEFAULT FALSE,
    email_token VARCHAR(255),
    password_reset_token VARCHAR(255),
    password_reset_expires DATETIME,
    is_active BOOLEAN DEFAULT TRUE,
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    KEY idx_email (email),
    KEY idx_username (username),
    KEY idx_role_id (role_id),
    KEY idx_is_active (is_active),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: fish_wiki
-- Ficha principal de cada pez
-- =====================================================
CREATE TABLE fish_wiki (
    id INT PRIMARY KEY AUTO_INCREMENT,
    common_name VARCHAR(100) NOT NULL,
    scientific_name VARCHAR(150),
    family VARCHAR(100),
    origin VARCHAR(100),
    size_min DECIMAL(5, 2) COMMENT 'Tamaño mínimo en cm',
    size_max DECIMAL(5, 2) COMMENT 'Tamaño máximo en cm',
    temperature_min DECIMAL(3, 1) COMMENT 'Temperatura mínima en °C',
    temperature_max DECIMAL(3, 1) COMMENT 'Temperatura máxima en °C',
    ph_min DECIMAL(3, 1),
    ph_max DECIMAL(3, 1),
    hardness_min DECIMAL(5, 2) COMMENT 'Dureza mínima en dGH',
    hardness_max DECIMAL(5, 2) COMMENT 'Dureza máxima en dGH',
    behavior TEXT,
    compatibility TEXT,
    difficulty ENUM('muy_fácil', 'fácil', 'medio', 'difícil', 'muy_difícil') DEFAULT 'medio',
    feeding TEXT,
    lifespan INT COMMENT 'Esperanza de vida en años',
    description LONGTEXT,
    main_image VARCHAR(255),
    status ENUM('pendiente', 'aprobado', 'rechazado') DEFAULT 'pendiente',
    author_id INT NOT NULL,
    rejection_reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    KEY idx_common_name (common_name),
    KEY idx_status (status),
    KEY idx_author_id (author_id),
    KEY idx_difficulty (difficulty),
    FULLTEXT INDEX idx_fulltext_fish (common_name, scientific_name, description),
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: fish_images
-- Galería de imágenes por pez
-- =====================================================
CREATE TABLE fish_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fish_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    title VARCHAR(150),
    description TEXT,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    KEY idx_fish_id (fish_id),
    KEY idx_uploaded_by (uploaded_by),
    FOREIGN KEY (fish_id) REFERENCES fish_wiki(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: fish_edit_history
-- Historial de ediciones
-- =====================================================
CREATE TABLE fish_edit_history (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fish_id INT NOT NULL,
    edited_by INT NOT NULL,
    changes_json LONGTEXT COMMENT 'JSON con cambios realizados',
    reason VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    KEY idx_fish_id (fish_id),
    KEY idx_edited_by (edited_by),
    FOREIGN KEY (fish_id) REFERENCES fish_wiki(id) ON DELETE CASCADE,
    FOREIGN KEY (edited_by) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: fish_reports
-- Reportes de errores en fichas
-- =====================================================
CREATE TABLE fish_reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fish_id INT NOT NULL,
    reporter_id INT NOT NULL,
    report_type ENUM('datos_incorrectos', 'compatibilidad', 'imagen', 'otro') NOT NULL,
    comment TEXT NOT NULL,
    status ENUM('nuevo', 'en_revisión', 'resuelto') DEFAULT 'nuevo',
    admin_response TEXT,
    resolved_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    KEY idx_fish_id (fish_id),
    KEY idx_reporter_id (reporter_id),
    KEY idx_status (status),
    KEY idx_created_at (created_at),
    FOREIGN KEY (fish_id) REFERENCES fish_wiki(id) ON DELETE CASCADE,
    FOREIGN KEY (reporter_id) REFERENCES users(id) ON DELETE RESTRICT,
    FOREIGN KEY (resolved_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: aquariums
-- Acuarios del usuario
-- =====================================================
CREATE TABLE aquariums (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    volume_liters DECIMAL(8, 2),
    type ENUM('agua_dulce', 'agua_salada', 'brackish') DEFAULT 'agua_dulce',
    dimensions_length DECIMAL(6, 2) COMMENT 'Largo en cm',
    dimensions_width DECIMAL(6, 2) COMMENT 'Ancho en cm',
    dimensions_height DECIMAL(6, 2) COMMENT 'Alto en cm',
    filter_type VARCHAR(100),
    lighting_hours INT,
    co2_injection BOOLEAN,
    main_image VARCHAR(255),
    status ENUM('activo', 'inactivo', 'en_construcción') DEFAULT 'activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    KEY idx_user_id (user_id),
    KEY idx_status (status),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: terrariums
-- Terrarios del usuario (plantas, reptiles, etc.)
-- =====================================================
CREATE TABLE terrariums (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    volume_liters DECIMAL(8, 2),
    type ENUM('tropical', 'desértico', 'subtropical', 'húmedo', 'seco') DEFAULT 'tropical',
    dimensions_length DECIMAL(6, 2) COMMENT 'Largo en cm',
    dimensions_width DECIMAL(6, 2) COMMENT 'Ancho en cm',
    dimensions_height DECIMAL(6, 2) COMMENT 'Alto en cm',
    lighting_hours INT,
    heating_type VARCHAR(100),
    humidity_level INT COMMENT 'Porcentaje de humedad',
    temperature_min DECIMAL(3, 1),
    temperature_max DECIMAL(3, 1),
    main_image VARCHAR(255),
    status ENUM('activo', 'inactivo', 'en_construcción') DEFAULT 'activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    KEY idx_user_id (user_id),
    KEY idx_status (status),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: terrarium_inhabitants
-- Animales/Plantas en terrarios
-- =====================================================
CREATE TABLE terrarium_inhabitants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    terrarium_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50) COMMENT 'reptil, anfibio, insecto, planta, etc.',
    quantity INT DEFAULT 1,
    notes TEXT,
    added_date DATETIME,
    
    KEY idx_terrarium_id (terrarium_id),
    FOREIGN KEY (terrarium_id) REFERENCES terrariums(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: terrarium_gallery
-- Galería de fotos por terrario
-- =====================================================
CREATE TABLE terrarium_gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    terrarium_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    title VARCHAR(150),
    description TEXT,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    KEY idx_terrarium_id (terrarium_id),
    KEY idx_uploaded_by (uploaded_by),
    FOREIGN KEY (terrarium_id) REFERENCES terrariums(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: terrarium_maintenance
-- Bitácora de mantenimiento de terrarios
-- =====================================================
CREATE TABLE terrarium_maintenance (
    id INT PRIMARY KEY AUTO_INCREMENT,
    terrarium_id INT NOT NULL,
    log_type VARCHAR(50),
    description TEXT,
    reminder_enabled BOOLEAN DEFAULT FALSE,
    reminder_days INT,
    reminder_last_sent DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    KEY idx_terrarium_id (terrarium_id),
    KEY idx_created_at (created_at),
    FOREIGN KEY (terrarium_id) REFERENCES terrariums(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: aquarium_fish
-- Peces en cada acuario (solo aprobados)
-- =====================================================
CREATE TABLE aquarium_fish (
    id INT PRIMARY KEY AUTO_INCREMENT,
    aquarium_id INT NOT NULL,
    fish_id INT NOT NULL,
    quantity INT DEFAULT 1,
    notes TEXT,
    added_date DATETIME,
    
    KEY idx_aquarium_id (aquarium_id),
    KEY idx_fish_id (fish_id),
    UNIQUE KEY unique_aquarium_fish (aquarium_id, fish_id),
    FOREIGN KEY (aquarium_id) REFERENCES aquariums(id) ON DELETE CASCADE,
    FOREIGN KEY (fish_id) REFERENCES fish_wiki(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: aquarium_plants
-- Plantas en cada acuario
-- =====================================================
CREATE TABLE aquarium_plants (
    id INT PRIMARY KEY AUTO_INCREMENT,
    aquarium_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    quantity INT DEFAULT 1,
    care_level ENUM('fácil', 'medio', 'difícil') DEFAULT 'medio',
    lighting_requirement VARCHAR(50),
    added_date DATETIME,
    notes TEXT,
    
    KEY idx_aquarium_id (aquarium_id),
    FOREIGN KEY (aquarium_id) REFERENCES aquariums(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: aquarium_substrates
-- Sustratos en cada acuario
-- =====================================================
CREATE TABLE aquarium_substrates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    aquarium_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50),
    quantity_kg DECIMAL(8, 2),
    color VARCHAR(50),
    notes TEXT,
    added_date DATETIME,
    
    KEY idx_aquarium_id (aquarium_id),
    FOREIGN KEY (aquarium_id) REFERENCES aquariums(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: maintenance_logs
-- Bitácora de mantenimiento
-- =====================================================
CREATE TABLE maintenance_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    aquarium_id INT NOT NULL,
    log_type ENUM('cambio_agua', 'limpieza_filtro', 'fertilizante', 'medicamento', 'otro') NOT NULL,
    description TEXT,
    percentage INT COMMENT 'Porcentaje de agua cambiado',
    notes TEXT,
    reminder_enabled TINYINT(1) DEFAULT 0,
    reminder_days INT DEFAULT NULL,
    reminder_next_at DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    KEY idx_aquarium_id (aquarium_id),
    KEY idx_log_type (log_type),
    KEY idx_created_at (created_at),
    KEY idx_reminder_next_at (reminder_next_at),
    FOREIGN KEY (aquarium_id) REFERENCES aquariums(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: gallery_images
-- Galería de imágenes por acuario
-- =====================================================
CREATE TABLE gallery_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    aquarium_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    title VARCHAR(150),
    description TEXT,
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    KEY idx_aquarium_id (aquarium_id),
    FOREIGN KEY (aquarium_id) REFERENCES aquariums(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: aquarium_gallery
-- Galería alternativa de imágenes por acuario
-- =====================================================
CREATE TABLE aquarium_gallery (
    id INT PRIMARY KEY AUTO_INCREMENT,
    aquarium_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    title VARCHAR(150),
    description TEXT,
    uploaded_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    KEY idx_aquarium_id (aquarium_id),
    KEY idx_uploaded_by (uploaded_by),
    FOREIGN KEY (aquarium_id) REFERENCES aquariums(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABLA: articles
-- =====================================================
CREATE TABLE articles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    content LONGTEXT NOT NULL,
    category ENUM('DIY', 'Blog', 'Evento') NOT NULL DEFAULT 'Blog',
    author_id INT NOT NULL,
    image_path VARCHAR(255),
    is_published BOOLEAN DEFAULT FALSE,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    KEY idx_author_id (author_id),
    KEY idx_category (category),
    KEY idx_is_published (is_published),
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- Crear usuario admin por defecto (contraseña: admin123)
-- =====================================================
INSERT INTO users (username, email, password_hash, full_name, role_id, email_verified, is_active) 
VALUES (
    'admin',
    'admin@acuario.local',
    '$2y$10$YIjlrPDorAQvapHxYT3.e.V5Tj/X.5h9bsI9T8w1QDKZ6WKlNteDi',
    'Administrador',
    1,
    TRUE,
    TRUE
);
