-- =====================================================
-- DATOS DE EJEMPLO PARA SISTEMA DE ACUARISMO
-- Ejecutar DESPUÉS de database.sql
-- =====================================================

USE germangu_acuario_db;

-- =====================================================
-- PECES POPULARES (Ya aprobados)
-- =====================================================

INSERT INTO fish_wiki (common_name, scientific_name, family, origin, size_min, size_max, temperature_min, temperature_max, ph_min, ph_max, hardness_min, hardness_max, behavior, compatibility, difficulty, feeding, lifespan, description, status, author_id) VALUES
('Pez Betta', 'Betta splendens', 'Osphronemidae', 'Tailandia, Camboya', 5.0, 7.0, 24.0, 28.0, 6.5, 7.5, 5.0, 15.0, 
'Territorial, agresivo con otros machos', 'No compatible con otros bettas machos. Bueno con peces pacíficos pequeños.', 'fácil',
'Omnívoro: pellets, alimento vivo, larvas de mosquito', 3,
'El pez Betta, también conocido como luchador de Siam, es famoso por sus colores brillantes y aletas espectaculares. Los machos son muy territoriales y no deben alojarse juntos. Son peces resistentes ideales para principiantes.',
'aprobado', 1),

('Guppy', 'Poecilia reticulata', 'Poeciliidae', 'América del Sur', 3.0, 6.0, 22.0, 28.0, 6.8, 7.8, 10.0, 20.0,
'Pacífico, muy activo, vive en cardúmenes', 'Excelente con peces comunitarios pacíficos', 'muy_fácil',
'Omnívoro: hojuelas, alimento vivo, vegetales', 2,
'Los guppys son peces vivíparos muy populares por su facilidad de cría y colorido. Son ideales para principiantes y se reproducen fácilmente en acuarios comunitarios. Muy activos y pacíficos.',
'aprobado', 1),

('Neón Tetra', 'Paracheirodon innesi', 'Characidae', 'Amazonas, Perú', 3.0, 4.0, 20.0, 26.0, 6.0, 7.0, 1.0, 10.0,
'Pacífico, vive en cardúmenes grandes', 'Perfecto para acuarios comunitarios con peces pequeños', 'fácil',
'Omnívoro: micro pellets, alimento congelado, larvas', 5,
'El neón es uno de los peces más populares del acuarismo. Su coloración azul y roja brillante los hace destacar en plantados. Deben mantenerse en grupos de al menos 10 individuos.',
'aprobado', 1),

('Corydora Panda', 'Corydoras panda', 'Callichthyidae', 'Perú', 4.0, 5.0, 20.0, 25.0, 6.5, 7.5, 2.0, 12.0,
'Pacífico, limpiador de fondo', 'Excelente con todos los peces pacíficos', 'fácil',
'Omnívoro: tabletas de fondo, alimento congelado', 10,
'Las corydoras panda son excelentes limpiadores de fondo. Son peces sociales que deben mantenerse en grupos de 6 o más. Su patrón blanco y negro las hace muy atractivas.',
'aprobado', 1),

('Molly Negro', 'Poecilia sphenops', 'Poeciliidae', 'México, Colombia', 6.0, 12.0, 24.0, 28.0, 7.0, 8.5, 15.0, 30.0,
'Pacífico, activo', 'Compatible con peces comunitarios medianos', 'fácil',
'Omnívoro con preferencia por algas y vegetales', 5,
'Los mollys negros son peces resistentes y fáciles de mantener. Toleran aguas duras y ligeramente salinas. Son excelentes comedores de algas.',
'aprobado', 1),

('Platy', 'Xiphophorus maculatus', 'Poeciliidae', 'México, Guatemala', 4.0, 6.0, 18.0, 28.0, 7.0, 8.0, 10.0, 28.0,
'Muy pacífico, ideal para comunitarios', 'Perfecto con guppys, mollys, tetras', 'muy_fácil',
'Omnívoro: hojuelas, algas, vegetales', 3,
'Los platys son peces vivíparos muy resistentes y coloridos. Vienen en muchas variedades de colores. Son ideales para principiantes y se reproducen con facilidad.',
'aprobado', 1),

('Ángel Escalar', 'Pterophyllum scalare', 'Cichlidae', 'Amazonas', 10.0, 15.0, 24.0, 30.0, 6.0, 7.5, 3.0, 10.0,
'Territorial al criar, generalmente pacífico', 'Compatible con tetras grandes, corydoras', 'medio',
'Omnívoro: pellets, alimento vivo, artemias', 10,
'El pez ángel es majestuoso y elegante. Requiere acuarios altos con plantas. Puede ser territorial durante la cría. No es compatible con peces muy pequeños que puedan caber en su boca.',
'aprobado', 1),

('Ramirezi', 'Mikrogeophagus ramirezi', 'Cichlidae', 'Venezuela, Colombia', 5.0, 7.0, 26.0, 30.0, 6.0, 7.0, 5.0, 15.0,
'Pacífico, territorial al criar', 'Bueno con tetras, corydoras, rasboras', 'medio',
'Omnívoro: pellets pequeños, alimento vivo', 4,
'El ramirezi o mariposa es un cíclido enano muy colorido. Requiere agua cálida y limpia. Son peces sensibles que necesitan parámetros estables. Hermosos en acuarios plantados.',
'aprobado', 1),

('Gourami Azul', 'Trichogaster trichopterus', 'Osphronemidae', 'Sudeste Asiático', 10.0, 15.0, 22.0, 28.0, 6.0, 8.0, 5.0, 20.0,
'Pacífico, puede ser territorial', 'Bueno con peces comunitarios de tamaño similar', 'fácil',
'Omnívoro: pellets, alimento vivo, vegetales', 5,
'Los gouramis azules son peces laberinto que respiran aire. Son resistentes y coloridos. Los machos pueden ser territoriales entre sí.',
'aprobado', 1),

('Otocinclus', 'Otocinclus affinis', 'Loricariidae', 'Sudamérica', 4.0, 5.0, 22.0, 26.0, 6.5, 7.5, 2.0, 15.0,
'Muy pacífico, limpiador de algas', 'Excelente con todos los peces pacíficos', 'medio',
'Herbívoro: algas, obleas de algas, vegetales', 5,
'Los otos son excelentes comedores de algas. Deben mantenerse en grupos de 6+. Requieren acuarios maduros con algas. Son sensibles a los cambios de agua.',
'aprobado', 1);

-- =====================================================
-- ACUARIOS DE EJEMPLO
-- =====================================================

INSERT INTO aquariums (user_id, name, description, volume_liters, type, dimensions_length, dimensions_width, dimensions_height, filter_type, lighting_hours, co2_injection, status) VALUES
(1, 'Acuario Comunitario Tropical', 'Mi acuario principal con peces tropicales pacíficos y plantas naturales', 200.0, 'agua_dulce', 100.0, 50.0, 40.0, 'Filtro externo Eheim', 8, 1, 'activo'),
(1, 'Nano Plantado', 'Pequeño acuario densamente plantado estilo Iwagumi', 30.0, 'agua_dulce', 40.0, 25.0, 30.0, 'Filtro mochila', 10, 1, 'activo'),
(1, 'Acuario de Cría', 'Acuario dedicado a la reproducción de guppys', 60.0, 'agua_dulce', 60.0, 30.0, 35.0, 'Filtro esponja', 6, 0, 'activo');

-- =====================================================
-- PECES EN ACUARIOS
-- =====================================================

INSERT INTO aquarium_fish (aquarium_id, fish_id, quantity, notes, added_date) VALUES
(1, 3, 15, 'Cardumen principal, muy activos', NOW()),
(1, 4, 6, 'Limpiadores de fondo, muy activos', NOW()),
(1, 7, 2, 'Pareja establecida', NOW()),
(1, 10, 8, 'Equipo de limpieza de algas', NOW()),
(2, 2, 6, 'Coloridos y activos', NOW()),
(2, 3, 10, 'Cardumen secundario', NOW()),
(3, 2, 20, 'Varias generaciones, muchos alevines', NOW());

-- =====================================================
-- PLANTAS DE ACUARIO
-- =====================================================

INSERT INTO aquarium_plants (aquarium_id, name, quantity, care_level, lighting_requirement, added_date, notes) VALUES
(1, 'Anubias Barteri', 3, 'fácil', 'Baja', NOW(), 'Atadas a rocas, muy resistentes'),
(1, 'Helecho de Java', 5, 'fácil', 'Media', NOW(), 'Crecimiento lento pero seguro'),
(1, 'Rotala Rotundifolia', 10, 'medio', 'Alta', NOW(), 'Tallos rojos, necesita podas frecuentes'),
(1, 'Vallisneria', 15, 'fácil', 'Media', NOW(), 'Planta de fondo, crece rápido'),
(2, 'Monte Carlo', 1, 'medio', 'Alta', NOW(), 'Tapizante, requiere CO2'),
(2, 'Glossostigma', 1, 'difícil', 'Alta', NOW(), 'Tapizante delicada'),
(2, 'Riccia Fluitans', 1, 'fácil', 'Alta', NOW(), 'Atada a roca');

-- =====================================================
-- SUSTRATOS
-- =====================================================

INSERT INTO aquarium_substrates (aquarium_id, name, type, quantity_kg, color, notes, added_date) VALUES
(1, 'ADA Aqua Soil', 'Nutritivo', 9.0, 'Negro', 'Excelente para plantas', NOW()),
(1, 'Grava Negra', 'Inerte', 5.0, 'Negro', 'Capa superior decorativa', NOW()),
(2, 'ADA Aqua Soil', 'Nutritivo', 3.0, 'Negro', 'Perfecto para nano plantados', NOW()),
(3, 'Arena de Río', 'Inerte', 4.0, 'Beige', 'Económico y seguro para alevines', NOW());

-- =====================================================
-- REGISTROS DE MANTENIMIENTO
-- =====================================================

INSERT INTO maintenance_logs (aquarium_id, log_type, description, percentage, notes, reminder_enabled, reminder_days, reminder_next_at, created_at) VALUES
(1, 'cambio_agua', 'Cambio de agua semanal', 30, 'Agua tratada con acondicionador', 1, 7, DATE_ADD(NOW(), INTERVAL 7 DAY), DATE_SUB(NOW(), INTERVAL 2 DAY)),
(1, 'limpieza_filtro', 'Limpieza de prefiltros', NULL, 'Solo enjuagué las esponjas con agua del acuario', 1, 14, DATE_ADD(NOW(), INTERVAL 14 DAY), DATE_SUB(NOW(), INTERVAL 5 DAY)),
(1, 'fertilizante', 'Fertilización semanal', NULL, 'Seachem Flourish Excel y Flourish', 1, 7, DATE_ADD(NOW(), INTERVAL 7 DAY), DATE_SUB(NOW(), INTERVAL 1 DAY)),
(2, 'cambio_agua', 'Cambio de agua nano', 40, 'Cambios más frecuentes por el tamaño', 1, 5, DATE_ADD(NOW(), INTERVAL 5 DAY), DATE_SUB(NOW(), INTERVAL 3 DAY)),
(2, 'otro', 'Poda de plantas', NULL, 'Monte Carlo y rotala necesitan podas constantes', 0, NULL, NULL, DATE_SUB(NOW(), INTERVAL 7 DAY)),
(3, 'cambio_agua', 'Cambio de agua para alevines', 20, 'Cambios pequeños pero frecuentes', 1, 3, DATE_ADD(NOW(), INTERVAL 3 DAY), NOW());

-- =====================================================
-- TERRARIOS DE EJEMPLO
-- =====================================================

INSERT INTO terrariums (user_id, name, description, volume_liters, type, dimensions_length, dimensions_width, dimensions_height, lighting_hours, heating_type, humidity_level, temperature_min, temperature_max, status) VALUES
(1, 'Terrario Tropical', 'Terrario tropical húmedo con plantas epífitas', 100.0, 'tropical', 60.0, 45.0, 60.0, 12, 'Lámpara cerámica', 80, 22.0, 28.0, 'activo'),
(1, 'Vivario Desértico', 'Hábitat árido para reptiles del desierto', 80.0, 'desértico', 90.0, 45.0, 45.0, 10, 'Manta térmica + lámpara', 30, 25.0, 35.0, 'activo');

-- =====================================================
-- HABITANTES DE TERRARIOS
-- =====================================================

INSERT INTO terrarium_inhabitants (terrarium_id, name, type, quantity, notes, added_date) VALUES
(1, 'Gecko Crestado', 'reptil', 2, 'Pareja adulta, se alimentan de frutas', NOW()),
(1, 'Isópodos', 'insecto', 50, 'Equipo de limpieza, se reproducen solos', NOW()),
(1, 'Collembola', 'insecto', 100, 'Control de moho', NOW()),
(2, 'Gecko Leopardo', 'reptil', 1, 'Macho adulto, muy dócil', NOW());

-- =====================================================
-- MANTENIMIENTO DE TERRARIOS
-- =====================================================

INSERT INTO terrarium_maintenance (terrarium_id, log_type, description, reminder_enabled, reminder_days, reminder_last_sent, created_at) VALUES
(1, 'Alimentación', 'Alimentar geckos con papilla de frutas', 1, 2, NULL, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(1, 'Nebulización', 'Sistema automático de nebulización', 1, 1, NULL, NOW()),
(1, 'Limpieza', 'Retirar excrementos y comida no consumida', 1, 3, NULL, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(2, 'Alimentación', 'Grillos y tenebrios espolvoreados con calcio', 1, 3, NULL, NOW()),
(2, 'Limpieza', 'Cambio parcial de sustrato', 0, NULL, NULL, DATE_SUB(NOW(), INTERVAL 10 DAY));

-- =====================================================
-- ARTÍCULOS DE EJEMPLO
-- =====================================================

INSERT INTO articles (title, description, content, category, author_id, is_published, views, created_at) VALUES
('Cómo hacer un plantado low-tech', 'Guía completa para crear un acuario plantado sin CO2 presurizado', 
'<h2>Introducción</h2><p>Los acuarios plantados low-tech son una excelente opción para principiantes que quieren tener plantas naturales sin la complejidad del CO2 presurizado.</p><h3>Materiales necesarios</h3><ul><li>Sustrato nutritivo</li><li>Plantas de bajo requerimiento lumínico</li><li>Iluminación LED adecuada</li><li>Filtro</li></ul><h3>Plantas recomendadas</h3><p>Anubias, Helecho de Java, Cryptocoryne, Vallisneria, Sagitaria...</p>', 
'DIY', 1, 1, 245, DATE_SUB(NOW(), INTERVAL 15 DAY)),

('Ciclado del acuario: Guía completa', 'Todo lo que necesitas saber sobre el ciclado antes de añadir peces', 
'<h2>¿Qué es el ciclado?</h2><p>El ciclado es el proceso de establecer las bacterias beneficiosas que convertirán los desechos tóxicos en sustancias menos dañinas.</p><h3>Pasos del ciclado</h3><ol><li>Llenar el acuario</li><li>Añadir fuente de amoniaco</li><li>Esperar 4-6 semanas</li><li>Monitorear parámetros</li></ol>', 
'Blog', 1, 1, 589, DATE_SUB(NOW(), INTERVAL 30 DAY)),

('Evento: Concurso de Aquascaping 2025', 'Participa en el concurso nacional de aquascaping', 
'<h2>Bases del concurso</h2><p>Fecha límite: 31 de marzo de 2025</p><p>Categorías: Iwagumi, Nature Style, Dutch Style</p><p>Premios: $10,000 primer lugar</p>', 
'Evento', 1, 1, 156, DATE_SUB(NOW(), INTERVAL 5 DAY));

-- =====================================================
-- GALERÍA DE ACUARIOS (Imágenes de ejemplo)
-- =====================================================

INSERT INTO aquarium_gallery (aquarium_id, image_path, title, description, uploaded_by, created_at) VALUES
(1, 'aquario-tropical-1.jpg', 'Vista frontal del acuario tropical', 'Acuario en su mejor estado con buena iluminación', 1, NOW()),
(1, 'aquario-tropical-2.jpg', 'Detalles de plantas', 'Plantas de fondo en buen crecimiento', 1, NOW()),
(2, 'nano-plantado-1.jpg', 'Nano acuario estilo Iwagumi', 'Pequeño acuario con piedras y musgo', 1, NOW()),
(3, 'acuario-cria-1.jpg', 'Acuario de cría de guppys', 'Muchos alevines en buen estado', 1, NOW());

-- Actualizar las imágenes principales de los acuarios
UPDATE aquariums SET main_image = 'aquario-tropical-1.jpg' WHERE id = 1;
UPDATE aquariums SET main_image = 'nano-plantado-1.jpg' WHERE id = 2;
UPDATE aquariums SET main_image = 'acuario-cria-1.jpg' WHERE id = 3;

-- =====================================================
-- TERRARIUM GALLERY (Imágenes de terrarios)
-- =====================================================

INSERT INTO terrarium_gallery (terrarium_id, image_path, title, description, uploaded_by, created_at) VALUES
(1, 'terrario-tropical-1.jpg', 'Vista general del terrario tropical', 'Terrario con buenos niveles de humedad', 1, NOW()),
(2, 'terrario-desertico-1.jpg', 'Terrario desértico con gecko', 'Ambiente árido perfecto para reptiles', 1, NOW());

-- Actualizar las imágenes principales de los terrarios
UPDATE terrariums SET main_image = 'terrario-tropical-1.jpg' WHERE id = 1;
UPDATE terrariums SET main_image = 'terrario-desertico-1.jpg' WHERE id = 2;

-- =====================================================
-- REPORTES DE PECES (Ejemplos)
-- =====================================================

INSERT INTO fish_reports (fish_id, reporter_id, report_type, comment, status, created_at) VALUES
(7, 1, 'datos_incorrectos', 'El tamaño máximo debería ser 20cm incluyendo las aletas', 'nuevo', DATE_SUB(NOW(), INTERVAL 2 DAY)),
(8, 1, 'compatibilidad', 'Los ramirezi no son tan compatibles con bettas, deberían marcarse como cuidado', 'nuevo', DATE_SUB(NOW(), INTERVAL 1 DAY));

-- =====================================================
-- FINALIZADO
-- =====================================================

SELECT 'Datos de ejemplo insertados correctamente' as resultado;
