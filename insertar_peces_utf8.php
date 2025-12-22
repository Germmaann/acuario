<?php
/**
 * Script temporal para insertar peces con codificación UTF-8 correcta
 */

require_once 'app/config/config.php';
require_once 'app/lib/Database.php';

$db = Database::getInstance();

// Limpiar peces de prueba anteriores
$db->prepare("DELETE af FROM aquarium_fish af JOIN fish_wiki fw ON af.fish_id = fw.id WHERE fw.author_id = 2")
   ->execute();
$db->prepare("DELETE FROM fish_wiki WHERE author_id = 2")->execute();

// Peces con acentos correctos
$peces = [
    [
        'common_name' => 'Guppy',
        'scientific_name' => 'Poecilia reticulata',
        'family' => 'Poeciliidae',
        'origin' => 'Trinidad y Tobago',
        'size_min' => 3, 'size_max' => 6,
        'temperature_min' => 22, 'temperature_max' => 26,
        'ph_min' => 6.8, 'ph_max' => 7.8,
        'hardness_min' => 4, 'hardness_max' => 8,
        'behavior' => 'Muy activo y pacífico',
        'compatibility' => 'Compatible con la mayoría de peces pequeños',
        'difficulty' => 'muy_fácil',
        'feeding' => 'Omnívoro: copos, pequeños crustáceos',
        'lifespan' => 2,
        'description' => 'El guppy es uno de los peces más coloridos y populares para acuarios comunitarios principiantes. Los machos son mucho más coloridos que las hembras, con colas largas y patrones complejos.',
        'status' => 'aprobado',
        'author_id' => 2
    ],
    [
        'common_name' => 'Pez Betta',
        'scientific_name' => 'Betta splendens',
        'family' => 'Osphronemidae',
        'origin' => 'Tailandia',
        'size_min' => 5, 'size_max' => 8,
        'temperature_min' => 24, 'temperature_max' => 27,
        'ph_min' => 6, 'ph_max' => 8,
        'hardness_min' => 4, 'hardness_max' => 18,
        'behavior' => 'Agresivo con otros machos, pacífico con hembras',
        'compatibility' => 'Los machos deben estar solos',
        'difficulty' => 'fácil',
        'feeding' => 'Carnívoro: insectos pequeños, dáfnias',
        'lifespan' => 3,
        'description' => 'Famoso por sus aletas largas y colores vibrantes que despliega en comportamiento territorial. Los machos son extremadamente agresivos entre sí.',
        'status' => 'aprobado',
        'author_id' => 2
    ],
    [
        'common_name' => 'Tetra Neón',
        'scientific_name' => 'Paracheirodon innesi',
        'family' => 'Characidae',
        'origin' => 'Sudamérica - Cuenca del Amazonas',
        'size_min' => 2, 'size_max' => 3,
        'temperature_min' => 20, 'temperature_max' => 24,
        'ph_min' => 6, 'ph_max' => 6.5,
        'hardness_min' => 4, 'hardness_max' => 8,
        'behavior' => 'Muy pacífico, debe mantenerse en grupos',
        'compatibility' => 'Excelente con otros tetras y peces pequeños',
        'difficulty' => 'fácil',
        'feeding' => 'Omnívoro: copos pequeños, dáfnias, mosquito pequeño',
        'lifespan' => 5,
        'description' => 'Pequeño pez brillante con una distintiva línea azul en el lomo y roja en el vientre que brilla bajo luz UV. Son escolarpes y deben mantenerse en grupos de al menos 6 individuos.',
        'status' => 'aprobado',
        'author_id' => 2
    ],
    [
        'common_name' => 'Corydoras',
        'scientific_name' => 'Corydoras aeneus',
        'family' => 'Callichthyidae',
        'origin' => 'Sudamérica',
        'size_min' => 4, 'size_max' => 7,
        'temperature_min' => 20, 'temperature_max' => 26,
        'ph_min' => 6, 'ph_max' => 7.5,
        'hardness_min' => 4, 'hardness_max' => 8,
        'behavior' => 'Pacífico, busca alimento en el fondo',
        'compatibility' => 'Compatible con la mayoría de peces',
        'difficulty' => 'fácil',
        'feeding' => 'Omnívoro: tabletas de fondo, insectos, algas',
        'lifespan' => 3,
        'description' => 'Pez de fondo limpiador muy útil para mantener el sustrato limpio. Tiene barbas táctiles que usa para buscar comida. Deben vivir en grupos de 3 o más individuos.',
        'status' => 'aprobado',
        'author_id' => 2
    ],
    [
        'common_name' => 'Pleco Común',
        'scientific_name' => 'Pterygoplichthys multiradiatus',
        'family' => 'Loricariidae',
        'origin' => 'Sudamérica',
        'size_min' => 15, 'size_max' => 50,
        'temperature_min' => 20, 'temperature_max' => 26,
        'ph_min' => 6, 'ph_max' => 7.5,
        'hardness_min' => 4, 'hardness_max' => 18,
        'behavior' => 'Nocturno, pacífico',
        'compatibility' => 'Compatible con peces grandes',
        'difficulty' => 'fácil',
        'feeding' => 'Herbívoro: algas, vegetales, tabletas de fondo',
        'lifespan' => 10,
        'description' => 'Gran limpiador de algas muy popular pero frecuentemente sobreestimado en cuanto a su capacidad limpiadora. Crece considerablemente con el tiempo.',
        'status' => 'aprobado',
        'author_id' => 2
    ],
    [
        'common_name' => 'Pez Ángel',
        'scientific_name' => 'Pterophyllum scalare',
        'family' => 'Cichlidae',
        'origin' => 'Sudamérica - Cuenca del Amazonas',
        'size_min' => 6, 'size_max' => 15,
        'temperature_min' => 24, 'temperature_max' => 28,
        'ph_min' => 6, 'ph_max' => 7.5,
        'hardness_min' => 4, 'hardness_max' => 8,
        'behavior' => 'Pacífico pero puede ser territorial',
        'compatibility' => 'Compatible con tetras y otros peces pacíficos',
        'difficulty' => 'medio',
        'feeding' => 'Omnívoro: copos, pequeños crustáceos, plantas',
        'lifespan' => 10,
        'description' => 'Hermoso pez con forma triangular característica y aletas dorsales y anales largas. Requiere tanques altos (mínimo 54 litros). Prefieren agua ligeramente ácida.',
        'status' => 'aprobado',
        'author_id' => 2
    ],
    [
        'common_name' => 'Molly',
        'scientific_name' => 'Poecilia sphenops',
        'family' => 'Poeciliidae',
        'origin' => 'México y América Central',
        'size_min' => 5, 'size_max' => 12,
        'temperature_min' => 20, 'temperature_max' => 28,
        'ph_min' => 7, 'ph_max' => 8.5,
        'hardness_min' => 4, 'hardness_max' => 18,
        'behavior' => 'Pacífico, activo',
        'compatibility' => 'Compatible con peces de agua neutra a ligeramente alcalina',
        'difficulty' => 'fácil',
        'feeding' => 'Omnívoro: copos, algas, vegetales',
        'lifespan' => 3,
        'description' => 'Pez robusto y colorido, ovovivíparo como el guppy. Existen varias variedades: negro, naranja, moteado, velo. Los machos tienen aleta dorsal más puntiaguda.',
        'status' => 'aprobado',
        'author_id' => 2
    ],
    [
        'common_name' => 'Pez Espada',
        'scientific_name' => 'Xiphophorus hellerii',
        'family' => 'Poeciliidae',
        'origin' => 'México y Guatemala',
        'size_min' => 5, 'size_max' => 13,
        'temperature_min' => 20, 'temperature_max' => 26,
        'ph_min' => 6.8, 'ph_max' => 7.8,
        'hardness_min' => 4, 'hardness_max' => 8,
        'behavior' => 'Activo, puede ser agresivo con otros machos',
        'compatibility' => 'Compatible con peces pacíficos de tamaño similar',
        'difficulty' => 'fácil',
        'feeding' => 'Omnívoro: copos, insectos pequeños, algas',
        'lifespan' => 4,
        'description' => 'Pez ovovivíparo caracterizado por la prolongación de la aleta caudal en forma de espada (solo en machos). Muy colorido, con patrones variables según la variedad.',
        'status' => 'aprobado',
        'author_id' => 2
    ],
    [
        'common_name' => 'Barbo Tigre',
        'scientific_name' => 'Puntius tetrazona',
        'family' => 'Cyprinidae',
        'origin' => 'Asia - Sumatra, Borneo',
        'size_min' => 3, 'size_max' => 7,
        'temperature_min' => 20, 'temperature_max' => 26,
        'ph_min' => 6, 'ph_max' => 7,
        'hardness_min' => 4, 'hardness_max' => 8,
        'behavior' => 'Activo, puede ser agresivo',
        'compatibility' => 'Mejor en grupos de 6 o más',
        'difficulty' => 'fácil',
        'feeding' => 'Omnívoro: copos, pequeños crustáceos, algas',
        'lifespan' => 4,
        'description' => 'Pez vistoso con cuerpo plateado y bandas negras verticales, similar a un tigre. Muy activo y juguetón. Los barbos son escolarpes pero pueden picar aletas de peces tranquilos.',
        'status' => 'aprobado',
        'author_id' => 2
    ],
    [
        'common_name' => 'Pez Disco',
        'scientific_name' => 'Symphysodon aequifasciatus',
        'family' => 'Cichlidae',
        'origin' => 'Sudamérica - Cuenca del Amazonas',
        'size_min' => 10, 'size_max' => 15,
        'temperature_min' => 25, 'temperature_max' => 31,
        'ph_min' => 5, 'ph_max' => 7,
        'hardness_min' => 4, 'hardness_max' => 8,
        'behavior' => 'Pacífico pero territorial',
        'compatibility' => 'Mejor con especies similares',
        'difficulty' => 'difícil',
        'feeding' => 'Carnívoro: gusanos, pequeños crustáceos, corazón de res',
        'lifespan' => 9,
        'description' => 'Hermoso pez redondo con patrones de color complejos y líneas verticales. Requiere agua muy cálida (28-31°C), ácida (pH 5-7) y blanda. Son sensibles a cambios de agua y parámetros.',
        'status' => 'aprobado',
        'author_id' => 2
    ],
    // PECES PENDIENTES DE MODERACIÓN
    [
        'common_name' => 'Pez Globo Enano',
        'scientific_name' => 'Carinotetraodon travancoricus',
        'family' => 'Tetraodontidae',
        'origin' => 'India',
        'size_min' => 2, 'size_max' => 3,
        'temperature_min' => 22, 'temperature_max' => 28,
        'ph_min' => 7, 'ph_max' => 8,
        'hardness_min' => 5, 'hardness_max' => 15,
        'behavior' => 'Territorial, puede ser agresivo',
        'compatibility' => 'Mejor mantenerlo solo o con peces rápidos',
        'difficulty' => 'medio',
        'feeding' => 'Carnívoro: caracoles, gusanos, alimento vivo',
        'lifespan' => 5,
        'description' => 'Pequeño pez globo de agua dulce con personalidad única. Excelente controlador de caracoles plaga. Requiere alimentación variada y puede morder aletas de otros peces.',
        'status' => 'pendiente',
        'author_id' => 2
    ],
    [
        'common_name' => 'Killifish Rayado',
        'scientific_name' => 'Aphyosemion striatum',
        'family' => 'Nothobranchiidae',
        'origin' => 'África Occidental',
        'size_min' => 4, 'size_max' => 6,
        'temperature_min' => 20, 'temperature_max' => 24,
        'ph_min' => 6, 'ph_max' => 7,
        'hardness_min' => 4, 'hardness_max' => 8,
        'behavior' => 'Pacífico, vive en la superficie',
        'compatibility' => 'Compatible con peces pequeños tranquilos',
        'difficulty' => 'medio',
        'feeding' => 'Carnívoro: alimento vivo, larvas de mosquito, dáfnias',
        'lifespan' => 2,
        'description' => 'Hermoso pez de colores vibrantes con líneas horizontales. Vida corta pero reproducción fácil. Prefiere tanques plantados con superficie tranquila.',
        'status' => 'pendiente',
        'author_id' => 2
    ],
    [
        'common_name' => 'Ramirezi',
        'scientific_name' => 'Mikrogeophagus ramirezi',
        'family' => 'Cichlidae',
        'origin' => 'Colombia y Venezuela',
        'size_min' => 5, 'size_max' => 7,
        'temperature_min' => 25, 'temperature_max' => 30,
        'ph_min' => 5, 'ph_max' => 7,
        'hardness_min' => 4, 'hardness_max' => 8,
        'behavior' => 'Pacífico, territorial suave',
        'compatibility' => 'Excelente para comunitarios pacíficos',
        'difficulty' => 'medio',
        'feeding' => 'Omnívoro: copos, pequeños crustáceos, larvas',
        'lifespan' => 3,
        'description' => 'Cíclido enano muy colorido con azules, amarillos y rojos brillantes. Requiere agua cálida y blanda. Forma parejas monógamas y puede reproducirse en acuarios.',
        'status' => 'pendiente',
        'author_id' => 2
    ],
    [
        'common_name' => 'Botia Payaso',
        'scientific_name' => 'Chromobotia macracanthus',
        'family' => 'Cobitidae',
        'origin' => 'Indonesia - Sumatra y Borneo',
        'size_min' => 15, 'size_max' => 30,
        'temperature_min' => 24, 'temperature_max' => 28,
        'ph_min' => 6, 'ph_max' => 7.5,
        'hardness_min' => 5, 'hardness_max' => 12,
        'behavior' => 'Activo, social, nocturno',
        'compatibility' => 'Debe vivir en grupos de 5 o más',
        'difficulty' => 'medio',
        'feeding' => 'Omnívoro: tabletas, caracoles, gusanos, vegetales',
        'lifespan' => 20,
        'description' => 'Pez de fondo con bandas naranjas y negras muy distintivas. Depredador natural de caracoles. Muy social y juguetón. Crece bastante y requiere acuarios grandes.',
        'status' => 'pendiente',
        'author_id' => 2
    ],
    [
        'common_name' => 'Otocinclus',
        'scientific_name' => 'Otocinclus affinis',
        'family' => 'Loricariidae',
        'origin' => 'Sudamérica',
        'size_min' => 3, 'size_max' => 5,
        'temperature_min' => 20, 'temperature_max' => 26,
        'ph_min' => 6, 'ph_max' => 7.5,
        'hardness_min' => 4, 'hardness_max' => 10,
        'behavior' => 'Pacífico, gregario',
        'compatibility' => 'Compatible con todos los peces pacíficos',
        'difficulty' => 'medio',
        'feeding' => 'Herbívoro: algas, obleas de algas, vegetales',
        'lifespan' => 5,
        'description' => 'Pequeño limpiador de algas muy eficiente. Debe vivir en grupos de al menos 6 individuos. Sensible a cambios de parámetros. Excelente para acuarios plantados.',
        'status' => 'pendiente',
        'author_id' => 2
    ]
];

// Insertar cada pez
$sql = "INSERT INTO fish_wiki (common_name, scientific_name, family, origin, size_min, size_max, 
        temperature_min, temperature_max, ph_min, ph_max, hardness_min, hardness_max, 
        behavior, compatibility, difficulty, feeding, lifespan, description, status, author_id) 
        VALUES (:common_name, :scientific_name, :family, :origin, :size_min, :size_max, 
        :temperature_min, :temperature_max, :ph_min, :ph_max, :hardness_min, :hardness_max, 
        :behavior, :compatibility, :difficulty, :feeding, :lifespan, :description, :status, :author_id)";

$insertados = 0;
foreach ($peces as $pez) {
    try {
        $db->prepare($sql)->execute($pez);
        $insertados++;
    } catch (Exception $e) {
        echo "Error insertando {$pez['common_name']}: " . $e->getMessage() . "\n";
    }
}

echo "✓ {$insertados} peces insertados correctamente con codificación UTF-8\n";
echo "  - Peces aprobados: 10\n";
echo "  - Peces pendientes de moderación: 5\n";
echo "\nVisita: http://localhost/acuario/public/fish para ver peces aprobados\n";
echo "Visita: http://localhost/acuario/public/admin/moderate-fish para moderar fichas pendientes\n";
