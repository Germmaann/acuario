<?php
/**
 * Script para insertar artículos de prueba
 * Ejecutar: http://localhost/Acuario/seed_articles.php
 */

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'acuario_db';

try {
    // Conectar a la base de datos
    $pdo = new PDO(
        "mysql:host=$host;charset=utf8mb4",
        $user,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Seleccionar la base de datos
    $pdo->exec("USE $database");

    // Obtener usuario admin (ID 1)
    $adminId = 1;

    // Artículos de prueba
    $articles = [
        [
            'title' => 'Cómo mantener peces tropicales en casa',
            'description' => 'Guía completa para principiantes sobre los cuidados básicos de peces tropicales. Aprende sobre temperatura, pH y alimentación.',
            'content' => '<h2>Introducción a los peces tropicales</h2>
<p>Los peces tropicales son algunas de las especies más hermosas y coloridas que puedes mantener en un acuario. En esta guía, te enseñaremos todo lo que necesitas saber para mantener un acuario tropical saludable.</p>

<h2>Requisitos básicos</h2>
<ul>
<li><strong>Temperatura:</strong> 24-28°C (mantén estable)</li>
<li><strong>pH:</strong> 6.5-7.5 dependiendo de la especie</li>
<li><strong>Iluminación:</strong> 8-10 horas diarias</li>
<li><strong>Filtración:</strong> Buena circulación de agua</li>
</ul>

<h2>Especies recomendadas para principiantes</h2>
<ul>
<li>Tetras de neón</li>
<li>Guppys</li>
<li>Corydoras</li>
<li>Pez ángel</li>
<li>Barbo de fuego</li>
</ul>

<h2>Alimentación</h2>
<p>Alimenta a tus peces 1-2 veces al día con porciones pequeñas. Usa alimentos de calidad formulados para peces tropicales. Varía la dieta con alimentos vivos ocasionalmente.</p>

<blockquote>
"Un acuario bien cuidado es un acuario con peces felices y saludables"
</blockquote>

<h2>Mantenimiento regular</h2>
<p>Realiza cambios de agua del 25-30% cada semana. Limpia el filtro regularmente y controla los parámetros del agua con un test kit.</p>',
            'category' => 'Blog',
            'is_published' => 1
        ],
        [
            'title' => 'DIY: Decoraciones de acuario naturales',
            'description' => 'Proyecto DIY para crear decoraciones de acuario usando materiales naturales. Madera, rocas y plantas vivas.',
            'content' => '<h2>Crea tus propias decoraciones</h2>
<p>No necesitas gastar mucho dinero en decoraciones de acuario. Con materiales naturales puedes crear un ambiente hermoso y natural para tus peces.</p>

<h2>Materiales necesarios</h2>
<ul>
<li>Madera sumergible (manzanita, madera de pantano)</li>
<li>Rocas lisas naturales</li>
<li>Arena y grava de calidad</li>
<li>Plantas de acuario (Anubias, Musgo de Java)</li>
<li>Agua destilada para enjuagar</li>
</ul>

<h2>Paso a paso</h2>
<ol>
<li><strong>Preparación:</strong> Enjuaga bien todos los materiales con agua destilada</li>
<li><strong>Disposición:</strong> Crea formaciones naturales en el acuario</li>
<li><strong>Plantación:</strong> Ata las plantas a la madera con hilo de pescar transparente</li>
<li><strong>Sustrato:</strong> Coloca primero la grava gruesa, luego la arena</li>
<li><strong>Llenado:</strong> Llena lentamente con agua para no disturbar la disposición</li>
</ol>

<h2>Beneficios</h2>
<ul>
<li>Ambiente más natural para los peces</li>
<li>Escondites seguros para alevines</li>
<li>Plantas que absorben nitratos</li>
<li>Aspecto más estético</li>
</ul>

<h2>Mantenimiento</h2>
<p>Limpia regularmente las decoraciones con un cepillo suave. Las plantas necesitarán podas ocasionales para mantener su forma.</p>',
            'category' => 'DIY',
            'is_published' => 1
        ],
        [
            'title' => 'Control de algas en acuarios',
            'description' => 'Métodos naturales y seguros para controlar el crecimiento de algas en tu acuario sin usar productos químicos.',
            'content' => '<h2>El problema de las algas</h2>
<p>Las algas pueden convertirse en un problema molesto si no se controlan adecuadamente. Pero no te preocupes, hay muchas formas naturales de mantenerlas bajo control.</p>

<h2>Causas principales del crecimiento de algas</h2>
<ul>
<li>Exceso de luz (más de 10 horas diarias)</li>
<li>Demasiado alimento → más nitratos</li>
<li>Falta de cambios de agua</li>
<li>Exceso de nutrientes en el sustrato</li>
<li>Agua con alto contenido de fosfato</li>
</ul>

<h2>Soluciones naturales</h2>

<h3>1. Reduce la iluminación</h3>
<p>Limita la luz a 8 horas diarias. Las algas necesitan luz para crecer, así que reducir la duración del fotoperíodo es muy efectivo.</p>

<h3>2. Aumenta los cambios de agua</h3>
<p>Realiza cambios de agua del 30-40% semanales. Esto reduce los nutrientes disponibles para las algas.</p>

<h3>3. Aumenta el flujo de agua</h3>
<p>Las algas prefieren aguas estancadas. Mejora la circulación con un mejor filtro o una bomba de aire.</p>

<h3>4. Usa comedores de algas</h3>
<p>Peces como Otocinclus, Pleco y Siamés de agua pueden ayudar a controlar las algas naturalmente.</p>

<h3>5. Planta plantas de crecimiento rápido</h3>
<p>Las plantas compiten con las algas por nutrientes. Hygrophila, Ludwigia y Rotala son excelentes opciones.</p>

<h2>Métodos mecánicos</h2>
<p>Para algas visibles, usa un cepillo de acuario suave o raspa de algas para removerlas manualmente sin dañar el cristal.</p>',
            'category' => 'Blog',
            'is_published' => 1
        ],
        [
            'title' => 'Encuentro de acuariófilos - Diciembre 2025',
            'description' => 'Evento comunitario para compartir experiencias, intercambiar peces y discutir técnicas avanzadas de acuarismo.',
            'content' => '<h2>¡Te invitamos a nuestro evento!</h2>
<p>Nos complace anunciar el primer encuentro anual de acuariófilos de nuestra comunidad.</p>

<h2>Detalles del evento</h2>
<ul>
<li><strong>Fecha:</strong> 28 de diciembre de 2025</li>
<li><strong>Hora:</strong> 10:00 AM - 5:00 PM</li>
<li><strong>Lugar:</strong> Centro comunitario local</li>
<li><strong>Entrada:</strong> Gratuita</li>
</ul>

<h2>Actividades</h2>
<ol>
<li><strong>Exposición de acuarios:</strong> Muestra tus mejores creaciones</li>
<li><strong>Conferencias:</strong> Expertos compartirán tips avanzados</li>
<li><strong>Intercambio de peces:</strong> Trae ejemplares extras para intercambiar</li>
<li><strong>Venta de plantas:</strong> Viveros locales ofrecerán sus productos</li>
<li><strong>Sorteos:</strong> Gana equipamiento de acuarismo</li>
<li><strong>Networking:</strong> Conoce otros entusiastas como tú</li>
</ol>

<h2>¿Qué llevar?</h2>
<ul>
<li>Fotos o videos de tus acuarios</li>
<li>Peces o plantas para intercambiar (en bolsas de transporte)</li>
<li>Lista de especies que deseas conseguir</li>
<li>Preguntas para hacer a los expertos</li>
</ul>

<h2>Registro</h2>
<p>Puedes registrarte gratuitamente en nuestro sitio web. Los espacios son limitados, así que asegúrate de inscribirte con anticipación.</p>

<blockquote>
"¡Esperamos verte en el evento más grande de acuarismo del año!"
</blockquote>',
            'category' => 'Evento',
            'is_published' => 1
        ],
        [
            'title' => 'Crianza de peces: Guía práctica',
            'description' => 'Todo lo que necesitas saber para criar peces con éxito. Desde el apareamiento hasta el cuidado de alevines.',
            'content' => '<h2>Introducción a la crianza</h2>
<p>Criar tus propios peces es una experiencia fascinante y gratificante. Esta guía te mostrará cómo hacerlo correctamente.</p>

<h2>Condiciones para el éxito reproductivo</h2>
<ul>
<li>Agua limpia con cambios frecuentes</li>
<li>Pareja bien alimentada</li>
<li>Plantas o lugares para esconderse</li>
<li>pH y temperatura estables</li>
<li>Alimento vivo disponible (importantes para alevines)</li>
</ul>

<h2>Especies fáciles para principiantes</h2>
<ul>
<li><strong>Guppys:</strong> Muy fáciles, dan a luz vivos</li>
<li><strong>Tetras:</strong> Más desafiantes pero factibles</li>
<li><strong>Corydoras:</strong> Desovan en plantas densas</li>
<li><strong>Cíclidos enanos:</strong> Parentales dedicados</li>
</ul>

<h2>Cuidado de alevines</h2>
<p>Los alevines son muy frágiles. Necesitan alimento pequeño (infusoria, algas de levadura) y agua limpia con cambios frecuentes pero graduales.</p>

<h2>Errores comunes a evitar</h2>
<ul>
<li>Alimentar en exceso a los adultos antes del desove</li>
<li>No tener suficientes plantas o escondites</li>
<li>Cambios bruscos de parámetros del agua</li>
<li>Usar alimento muy grande para los alevines</li>
<li>Falta de paciencia (algunos desoves toman meses)</li>
</ul>',
            'category' => 'Blog',
            'is_published' => 1
        ],
        [
            'title' => 'DIY: Filtro de esponja casero',
            'description' => 'Construye tu propio filtro de esponja eficiente y económico con materiales simples.',
            'content' => '<h2>¿Por qué hacer un filtro de esponja?</h2>
<p>Los filtros de esponja son excelentes para acuarios con alevines, camarones o cuando necesitas filtración suave. ¡Y puedes hacerlo tú mismo!</p>

<h2>Materiales necesarios</h2>
<ul>
<li>Tubería PVC de 4 pulgadas</li>
<li>Esponja azul gruesa</li>
<li>Tubo de aire</li>
<li>Bomba de aire pequeña</li>
<li>Codos y conectores PVC</li>
<li>Silicona de acuario</li>
</ul>

<h2>Herramientas</h2>
<ul>
<li>Sierra o serrucho</li>
<li>Cuchillo afilado</li>
<li>Pistola de silicona caliente</li>
<li>Marcador</li>
</ul>

<h2>Construcción paso a paso</h2>

<h3>Paso 1: Corta la tubería</h3>
<p>Corta la tubería PVC a la altura deseada (típicamente 15-20 cm).</p>

<h3>Paso 2: Prepara la esponja</h3>
<p>Corta la esponja para que quepa dentro de la tubería. Haz un agujero en el centro para el tubo de aire.</p>

<h3>Paso 3: Ensambla el tubo de aire</h3>
<p>Coloca el tubo de aire dentro del tubo PVC. Debe llegar casi al fondo.</p>

<h3>Paso 4: Inserta la esponja</h3>
<p>Coloca la esponja alrededor del tubo de aire. Asegúrala con silicona si es necesario.</p>

<h3>Paso 5: Crea la base</h3>
<p>Crea una base con PVC para mantener el filtro vertical. Puedes usar un T o un codo.</p>

<h2>Instalación final</h2>
<p>Coloca el filtro en el acuario y conecta el tubo de aire a la bomba. Ajusta el flujo según sea necesario.</p>

<h2>Ventajas</h2>
<ul>
<li>Muy económico (menos de $10)</li>
<li>Filtración suave</li>
<li>Fácil de limpiar</li>
<li>Customizable</li>
<li>Perfecto para alevines</li>
</ul>',
            'category' => 'DIY',
            'is_published' => 1
        ],
        [
            'title' => 'El ciclo del nitrógeno explicado',
            'description' => 'Comprende el ciclo del nitrógeno y por qué es crucial para mantener un acuario saludable.',
            'content' => '<h2>¿Qué es el ciclo del nitrógeno?</h2>
<p>El ciclo del nitrógeno es el proceso más importante en un acuario. Entenderlo es fundamental para mantener peces saludables.</p>

<h2>Las tres fases</h2>

<h3>Fase 1: Amonificación</h3>
<p>Los peces producen amoníaco (NH₃) como residuo. Las plantas y bacterias también generan amoníaco. Este es muy tóxico para los peces.</p>

<h3>Fase 2: Nitrificación - Nitrosomas</h3>
<p>Las bacterias Nitrosomonas convierten el amoníaco en nitrito (NO₂). El nitrito también es tóxico, pero menos que el amoníaco.</p>

<h3>Fase 3: Nitrificación - Nitrobacter</h3>
<p>Las bacterias Nitrobacter convierten el nitrito en nitrato (NO₃). El nitrato es menos tóxico y puede ser tolerado por los peces en cantidades moderadas.</p>

<h2>Eliminación de nitratos</h2>
<p>Los nitratos se pueden eliminar mediante:</p>
<ul>
<li>Cambios de agua (método más seguro)</li>
<li>Plantas de rápido crecimiento que los absorben</li>
<li>Filtros anaeróbicos especializados</li>
</ul>

<h2>Tiempo de ciclo</h2>
<p>Normalmente toma de 4 a 8 semanas para que un acuario se establezca completamente. Durante este tiempo, usa test kits para monitorear los parámetros.</p>

<h2>Acelerando el ciclo</h2>
<ul>
<li>Usa agua y sustrato de un acuario establecido</li>
<li>Agrega bacterias beneficiosas (starter bacteriano)</li>
<li>Mantén buena aireación</li>
<li>Alimenta poco a los peces al principio</li>
<li>Haz cambios de agua pequeños y frecuentes</li>
</ul>

<blockquote>
"Un acuario bien ciclado es la base de la salud de tus peces"
</blockquote>',
            'category' => 'Blog',
            'is_published' => 1
        ],
        [
            'title' => 'Terrarios: Introducción al hobby',
            'description' => 'Guía para principiantes sobre cómo crear y mantener un terrario hermoso y saludable.',
            'content' => '<h2>¿Qué es un terrario?</h2>
<p>Un terrario es un ecosistema en miniatura donde conviven plantas, animales pequeños y microorganismos en un ambiente controlado.</p>

<h2>Tipos de terrarios</h2>
<ul>
<li><strong>Tropical húmedo:</strong> Para ranas, sapos y plantas de selva</li>
<li><strong>Desértico:</strong> Para lagartos, serpientes y suculentas</li>
<li><strong>Subtropical:</strong> Combinación intermedia</li>
<li><strong>Bosque de niebla:</strong> Especial para orchídeas</li>
</ul>

<h2>Necesidades básicas</h2>
<ul>
<li>Contenedor apropiado (cristal o plástico resistente)</li>
<li>Sustrato adecuado para el tipo de terrario</li>
<li>Iluminación correcta (LED es ideal)</li>
<li>Sistema de calefacción o enfriamiento si es necesario</li>
<li>Ventilación adecuada</li>
<li>Agua destilada o destilada para mantener los niveles de humedad</li>
</ul>

<h2>Plantas recomendadas para principiantes</h2>
<ul>
<li>Musgo de Java (muy resistente)</li>
<li>Helechos mini (toleran humedad alta)</li>
<li>Pothos (crecimiento rápido)</li>
<li>Suculentas (para terrarios secos)</li>
</ul>

<h2>Animales populares</h2>
<ul>
<li>Ranas de cristal</li>
<li>Lagartos anolis</li>
<li>Geckos leopardo</li>
<li>Sapos de tormenta</li>
<li>Insectos (mantis, hormigas)</li>
</ul>',
            'category' => 'Blog',
            'is_published' => 1
        ]
    ];

    // Preparar statement
    $sql = "INSERT INTO articles (author_id, title, description, content, category, is_published, created_at) 
            VALUES (:author_id, :title, :description, :content, :category, :is_published, NOW())";
    
    $stmt = $pdo->prepare($sql);
    
    $inserted = 0;
    foreach ($articles as $article) {
        $result = $stmt->execute([
            ':author_id' => $adminId,
            ':title' => $article['title'],
            ':description' => $article['description'],
            ':content' => $article['content'],
            ':category' => $article['category'],
            ':is_published' => $article['is_published']
        ]);
        
        if ($result) {
            $inserted++;
        }
    }

    echo "<h2 style='color: #27ae60;'>✓ Artículos de prueba insertados</h2>";
    echo "<p>Se han creado <strong>$inserted artículos</strong> de prueba en diferentes categorías.</p>";
    echo "<h3>Artículos creados:</h3>";
    echo "<ul>";
    foreach ($articles as $article) {
        $icon = '';
        if ($article['category'] === 'DIY') {
            $icon = '🔨';
        } elseif ($article['category'] === 'Blog') {
            $icon = '📝';
        } else {
            $icon = '📅';
        }
        echo "<li><strong>{$icon} {$article['title']}</strong> ({$article['category']})</li>";
    }
    echo "</ul>";
    echo "<p><a href='http://localhost/Acuario/articles'>Ver todos los artículos</a> | <a href='http://localhost/Acuario/'>Volver al inicio</a></p>";

} catch (Exception $e) {
    echo "<h2 style='color: #e74c3c;'>✗ Error al insertar artículos</h2>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='http://localhost/Acuario/'>Volver al inicio</a></p>";
}
?>
