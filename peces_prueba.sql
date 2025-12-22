-- =====================================================
-- SCRIPT DE PRUEBA: 20 Peces para la Wiki Colaborativa
-- =====================================================

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

INSERT INTO fish_wiki (
    common_name, scientific_name, family, origin, 
    size_min, size_max, temperature_min, temperature_max,
    ph_min, ph_max, hardness_min, hardness_max,
    behavior, compatibility, difficulty, feeding, lifespan,
    description, status, author_id
) VALUES

-- 1. Guppy
('Guppy', 'Poecilia reticulata', 'Poeciliidae', 'Trinidad y Tobago',
3, 6, 22, 26, 6.8, 7.8, 4, 8,
'Muy activo y pacífico', 'Compatible con la mayoría de peces pequeños',
'muy_fácil', 'Omnívoro: copos, pequeños crustáceos', 2,
'El guppy es uno de los peces más coloridos y populares para acuarios comunitarios principiantes. Los machos son mucho más coloridos que las hembras, con colas largas y patrones complejos. Las hembras son grisáceas pero más grandes. Son ovovivíparos, lo que significa que dan a luz alevines vivos. Perfectos para acuarios pequeños y comunidades de peces pacíficos. Requieren agua limpia y con cambios regulares. Muy resistentes y fáciles de mantener.',
'aprobado', 2),

-- 2. Pez Betta
('Pez Betta', 'Betta splendens', 'Osphronemidae', 'Tailandia',
5, 8, 24, 27, 6, 8, 4, 18,
'Agresivo con otros machos, pacífico con hembras', 'Los machos deben estar solos',
'fácil', 'Carnívoro: insectos pequeños, dáfnias', 3,
'Famoso por sus aletas largas y colores vibrantes que despliega en comportamiento territorial. Los machos son extremadamente agresivos entre sí y nunca pueden compartir tanque. Las hembras pueden vivir en grupo (sorority) en tanques grandes bien plantados. Requiere espacio de al menos 20 litros para un macho solo. Tiene un laberinto que le permite respirar aire de la superficie. Son inteligentes y pueden ser entrenados. Colores naturales: rojo, azul, negro, blanco, naranja.',
'aprobado', 2),

-- 3. Tetra Neón
('Tetra Neón', 'Paracheirodon innesi', 'Characidae', 'Sudamérica - Cuenca del Amazonas',
2, 3, 20, 24, 6, 6.5, 4, 8,
'Muy pacífico, debe mantenerse en grupos', 'Excelente con otros tetras y peces pequeños',
'fácil', 'Omnívoro: copos pequeños, dáfnias, mosquito pequeño', 5,
'Pequeño pez brillante con una distintiva línea azul en el lomo y roja en el vientre que brilla bajo luz UV. Son escolarpes y deben mantenerse en grupos de al menos 6 individuos. Ideales para acuarios comunitarios pequeños y plantados. Prefieren agua ligeramente ácida y blanda. Muy sensibles a cambios bruscos de agua. No deben juntarse con peces que puedan depredarlos. Su brillantez es una señal de buena salud.',
'aprobado', 2),

-- 4. Corydoras
('Corydoras', 'Corydoras aeneus', 'Callichthyidae', 'Sudamérica',
4, 7, 20, 26, 6, 7.5, 4, 8,
'Pacífico, busca alimento en el fondo', 'Compatible con la mayoría de peces',
'fácil', 'Omnívoro: tabletas de fondo, insectos, algas', 3,
'Pez de fondo limpiador muy útil para mantener el sustrato limpio. Tiene barbas táctiles que usa para buscar comida. Deben vivir en grupos de 3 o más individuos. Requieren sustrato blando (arena o grava fina) para no dañar sus barbas. Muy activos por la noche. Son ovíparos y pueden reproducirse en acuarios bien establecidos. Requieren áreas de vegetación densa para sentirse seguros.',
'aprobado', 2),

-- 5. Pleco Común
('Pleco Común', 'Pterygoplichthys multiradiatus', 'Loricariidae', 'Sudamérica',
15, 50, 20, 26, 6, 7.5, 4, 18,
'Nocturno, pacífico', 'Compatible con peces grandes',
'fácil', 'Herbívoro: algas, vegetales, tabletas de fondo', 10,
'Gran limpiador de algas muy popular pero frecuentemente sobreestimado en cuanto a su capacidad limpiadora. Crece considerablemente con el tiempo (hasta 50 cm en acuarios grandes), requiriendo acuarios muy grandes cuando alcanza la madurez. Nocturno y tímido. Come principalmente algas pero también vegetación viva. Requiere lugares de reposo (cuevas de PVC). Produce muchos desechos. No debe mantenerse con otros plecos grandes.',
'aprobado', 2),

-- 6. Rana Acuática Africana
('Rana Acuática Africana', 'Xenopus laevis', 'Pipidae', 'África',
6, 13, 18, 24, 6.5, 8, 4, 18,
'Acuática, depredadora', 'No compatible con peces pequeños',
'medio', 'Carnívoro: camarones, gusanos, carne picada', 20,
'Anfibio completamente acuático (a diferencia de otras ranas). Depredador voraz que debe mantenerse separado de peces pequeños que pueden caber en su boca. Son oscuras y de piel rugosa. Muy activas por la noche. Requieren tanques de al menos 40 litros. Pueden vivir muchos años si se cuidan bien. Suelen confundirse con Hymenochirus (rana enana) que son mucho más pequeñas e inofensivas.',
'aprobado', 2),

-- 7. Molinesia Negra
('Molinesia Negra', 'Poecilia sphenops', 'Poeciliidae', 'México',
4, 8, 20, 28, 7, 8.5, 10, 25,
'Pacífica, activa, territorial moderado', 'Compatible con la mayoría de peces pacíficos',
'fácil', 'Omnívoro: copos, algas, invertebrados', 3,
'Pez ovovivíparo popular originario de agua salobres. Las hembras son más grandes que los machos. Tienen reproducción continua sin necesidad de reproducción estacional. Los alevines nacen completamente formados. Requieren agua ligeramente alcalina. Son comedoras de algas útiles. Toleran bien variaciones de parámetros. Algunos pueden desarrollar coloración verde debido a algas simbióticas. Muy robustas.',
'aprobado', 2),

-- 8. Pez Disco
('Pez Disco', 'Symphysodon aequifasciatus', 'Cichlidae', 'Sudamérica - Cuenca del Amazonas',
10, 15, 25, 31, 5, 7, 4, 8,
'Pacífico pero territorial', 'Mejor con especies similares', 
'difícil', 'Carnívoro: gusanos, pequeños crustáceos, corazón de res', 9,
'Hermoso pez redondo con patrones de color complejos y líneas verticales. Requiere agua muy cálida (28-31°C), ácida (pH 5-7) y blanda. Son sensibles a cambios de agua y parámetros. Requieren acuarios grandes (mínimo 150 litros). Se alimentan mejor con alimento vivo. Son territoriales pero pacíficos con peces similares. Su crianza es compleja. Requieren filtración potente y cambios frecuentes de agua.',
'aprobado', 2),

-- 9. Óscar
('Óscar', 'Astronotus ocellatus', 'Cichlidae', 'Sudamérica',
20, 35, 20, 26, 6, 7.5, 5, 19,
'Agresivo, territorial, inteligente', 'Requiere tanques específicos con peces grandes',
'medio', 'Carnívoro: peces pequeños, insectos, camarones', 15,
'Gran cíclido colorido e inteligente con patrones naranja y negro. Muy territorial y agresivo con peces más pequeños que puede comer. Son inteligentes y pueden ser entrenados a comer de la mano. Requieren acuarios grandes (mínimo 100 litros). Tienen comportamiento de juego activo. Pueden comer gusanos y camarones. Son depredadores y cazadores. Necesitan escondites. Crecen rápidamente.',
'aprobado', 2),

-- 10. Cardenal Jesús
('Cardenal Jesús', 'Cheirodon axelrodi', 'Characidae', 'Sudamérica - Cuenca del Amazonas',
2, 3, 20, 26, 5.5, 7, 4, 8,
'Muy pacífico, debe estar en grupos', 'Ideal para comunidades de peces pequeños',
'fácil', 'Omnívoro: copos pequeños, dáfnias, mosquito pequeño', 4,
'Similar al Tetra Neón pero con línea roja más extendida (también en la cabeza). Muy bonito en grupos grandes de al menos 10 individuos. Pequeño tetra escolar que requiere agua ácida y blanda. Son muy sensibles a parámetros de agua. Prefieren tanques bien plantados. No deben juntarse con peces depredadores. Muy delicado en acuarios nuevos. Excelentes para acuarios plantados pequeños.',
'aprobado', 2),

-- 11. Pez Payaso
('Pez Payaso', 'Amphiprion ocellaris', 'Pomacentridae', 'Océano Índico y Pacífico',
8, 11, 22, 26, 8, 8.4, 8, 12,
'Pacífico, requiere anémonas', 'Se asocia con anémonas en arrecife',
'medio', 'Omnívoro: zooplancton, algas, alimento para marino', 10,
'Famoso por su asociación simbiótica con anémonas hospederas. Naranja con franjas blancas y bordes negros. Requiere agua salada con salinidad 1.020-1.025. Deben criarse en pares. Son territoriales alrededor de sus anémonas. La anemona proporciona protección y el pez la protege. Requieren iluminación fuerte (acuarios arrecife). Alimentación especializada. Requiere tanques marineros establecidos (40+ litros).',
'aprobado', 2),

-- 12. Bacalao Limpiador
('Bacalao Limpiador', 'Pteruichthys kauderni', 'Callionymidae', 'Indonesia',
8, 10, 22, 26, 8, 8.5, 8, 12,
'Tímido, busca alimento en el fondo', 'Pacífico con peces compatibles',
'difícil', 'Carnívoro: copépodos, anfípodos vivos, pequeños crustáceos', 4,
'Pequeño pez muy colorido con patrón de banda roja y azul. Extremadamente difícil de mantener. Requiere alimento vivo pequeño (copépodos, anfípodos) que es difícil de conseguir. Tímido y reservado. Prefiere acuarios establecidos con sustrato arenoso. Requiere tanques con poca corriente. No compatible con agresores. Necesita plantas densas. Muy especializado, solo para acuaristas experimentados.',
'aprobado', 2),

-- 13. Pez Ángel
('Pez Ángel', 'Pterophyllum scalare', 'Cichlidae', 'Sudamérica - Cuenca del Amazonas',
6, 15, 24, 28, 6, 7.5, 4, 8,
'Pacífico pero puede ser territorial', 'Compatible con tetras y otros peces pacíficos',
'medio', 'Omnívoro: copos, pequeños crustáceos, plantas', 10,
'Hermoso pez con forma triangular característica y aletas dorsales y anales largas. Requiere tanques altos (mínimo 54 litros). Prefieren agua ligeramente ácida. Son muy sensibles a agua pobre y cambios de parámetros. Pueden comerse peces muy pequeños. Territoriales durante el desove. Son ovíparos y pueden reproducirse en acuarios. Requieren vegetación densa y lugares de reposo.',
'aprobado', 2),

-- 14. Peces Cebra
('Peces Cebra', 'Danio rerio', 'Cyprinidae', 'Asia',
4, 6, 18, 26, 6.5, 7.5, 4, 8,
'Activo, muy rápido, saltador', 'Mejor en grupos pequeños',
'muy_fácil', 'Omnívoro: copos, larvas de mosquito, pequeños invertebrados', 3,
'Pequeño pez rayado muy activo con líneas horizontales plateadas y doradas. Extremadamente resistente y fácil de mantener. Excelente para principiantes. Requiere espacio para nadar libremente. Deben mantenerse en grupos. Son saltadores, requieren cubierta en el acuario. Muy rápidos en movimiento. Toleran amplio rango de temperaturas y parámetros. Prefieren agua con movimiento. Acuarios comunitarios ideales.',
'aprobado', 2),

-- 15. Hacha Plateada
('Hacha Plateada', 'Carnegiella strigata', 'Gasteropelecidae', 'Sudamérica',
3, 4, 20, 26, 6, 7.5, 4, 8,
'Pacífico, vive en la superficie', 'Compatible con pequeños tetras',
'medio', 'Insectívoro: mosquitos pequeños, copos, dáfnias', 5,
'Pez pequeño con forma de hacha muy característica. Vive principalmente en la superficie comiendo insectos. Requiere cubierta ya que puede saltar fuera del agua. Prefieren acuarios plantados con superficie tranquila. Muy tímidos, requieren plantas densas para sentirse seguros. Pequeños grupos son ideales. Alimento vivo es preferido pero pueden acostumbrarse a copos. Requieren tanques sin agresores.',
'aprobado', 2),

-- 16. Chanda Roja
('Chanda Roja', 'Hyphessobrycon eques', 'Characidae', 'Sudamérica',
2, 2.5, 24, 28, 6, 7, 4, 8,
'Pacífico en grupos, activo', 'Muy social, debe estar en cardúmenes',
'fácil', 'Omnívoro: copos pequeños, dáfnias, mosquito pequeño', 3,
'Pequeño tetra rojo brillante muy atractivo. Hermoso cuando está en grupos grandes (10+). Requieren agua cálida. Sensibles a cambios de agua. Prefieren plantas densas. Color rojo intenso indica buena salud. Pueden comerse plantas delicadas. Muy activos. Ideales para acuarios pequeños plantados. Requieren alimento regular variado. Son vigorosos pero delicados en acuarios nuevos.',
'aprobado', 2),

-- 17. Leopardo Manchado
('Leopardo Manchado', 'Leporinus fasciatus', 'Anostomidae', 'Sudamérica',
10, 12, 20, 26, 6, 7.5, 4, 18,
'Activo, puede ser agresivo con peces pequeños', 'Mejor con peces de tamaño similar',
'medio', 'Omnívoro: vegetales, insectos, algas', 10,
'Pez activo con patrón de puntos negros sobre fondo amarillo/naranja. Llamados "Jumping Beans" porque saltan frecuentemente. Pueden comerse plantas acuáticas. Requieren espacio para nadar y sustrato arenoso. Son depredadores de invertebrados. Territoriales pero pueden vivir en grupos. Requieren alimentación variada incluyendo alimento vegetal. Muy activos y acrobáticos. Alcanzan tamaño considerable.',
'aprobado', 2),

-- 18. Gourami Besador
('Gourami Besador', 'Helostoma temminckii', 'Osphronemidae', 'Tailandia y Malasia',
10, 15, 22, 26, 6.5, 7.5, 4, 18,
'Pacífico, territorial', 'Compatible con peces similares',
'fácil', 'Omnívoro: copos, algas, invertebrados, plantas', 5,
'Interesante pez conocido por sus característicos "besos" (tocarse la boca). Son competidores de espacio territorial. Robusto y muy adaptable. Pueden vivir en parejas. Los "besos" es un comportamiento de demostración territorial o de cortejo. Pueden crecer bastante. Requieren plantas y espacios de descanso. Toleran amplio rango de parámetros. Buenos para acuarios comunitarios medianos. Muy resistentes.',
'aprobado', 2),

-- 19. Pampanito Plateado
('Pampanito Plateado', 'Metynnis argenteus', 'Serrasalmidae', 'Sudamérica',
5, 7, 20, 26, 6, 7, 6, 12,
'Pacífico, debe estar en grupos', 'Compatible con cardúmenes similares',
'fácil', 'Omnívoro: vegetales, copos, algas', 5,
'Pez redondo muy plateado con manchas circulares negras. Debe mantenerse en grupos de 4 o más. Son pacientes herbívoros. Pueden comer plantas delicadas - ofrece vegetales (lechuga, espinaca) regularmente. Muy activos. Prefieren agua ligeramente cálida. Requieren movimiento de agua. Buenos limpiadores de algas. Muy sociales y seguros en grupo. Excelentes para acuarios comunitarios grandes.',
'aprobado', 2),

-- 20. Pez Rojo
('Pez Rojo', 'Carassius auratus', 'Cyprinidae', 'Asia',
5, 30, 10, 24, 7, 7.5, 4, 8,
'Activo, desordenado, inteligente', 'Requiere tanques grandes',
'fácil', 'Omnívoro: copos, vegetales, insectos, algas', 20,
'Popular pez de feria originario de Asia. Puede crecer hasta 30 cm en acuarios adecuados. Requiere mínimo 40 litros por ejemplar. Prefieren agua fresca (15-24°C) aunque toleran más calor. Muy inteligentes y pueden ser entrenados. Producen muchos desechos, requieren filtración potente. Muy desordenados. Pueden vivir 20+ años si se cuidan bien. No deben mantenerse en peceras pequeñas (son mito urbano). Necesitan espacio real.',
'aprobado', 2);

-- =====================================================
-- Verificación
-- =====================================================
SELECT COUNT(*) as total_peces FROM fish_wiki WHERE status = 'aprobado';
