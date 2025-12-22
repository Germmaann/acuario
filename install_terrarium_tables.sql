-- =====================================================
-- INSTALACIÓN DE TABLAS DE TERRARIOS
-- =====================================================

-- =====================================================
-- TABLA: terrariums
-- Gestión de terrarios del usuario
-- =====================================================
CREATE TABLE IF NOT EXISTS terrariums (
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
CREATE TABLE IF NOT EXISTS terrarium_inhabitants (
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
CREATE TABLE IF NOT EXISTS terrarium_gallery (
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
CREATE TABLE IF NOT EXISTS terrarium_maintenance (
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
-- FIN DE INSTALACIÓN DE TABLAS DE TERRARIOS
-- =====================================================
