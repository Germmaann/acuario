<?php
// Inicializar variables por si no están definidas
$latestFish = $latestFish ?? [];
$latestAquariums = $latestAquariums ?? [];
$latestTerrariums = $latestTerrariums ?? [];
$latestArticles = $latestArticles ?? [];
?>

<style>
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 20px;
        text-align: center;
        border-radius: 15px;
        margin-bottom: 60px;
    }

    .hero-section h1 {
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .hero-section p {
        font-size: 18px;
        opacity: 0.95;
        max-width: 600px;
        margin: 0 auto 30px;
    }

    .hero-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 2px solid #ecf0f1;
    }

    .section-header h2 {
        font-size: 32px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .section-header a {
        color: #16a085;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }

    .section-header a:hover {
        color: #138d75;
        transform: translateX(5px);
    }

    .card-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 60px;
    }

    .feature-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .card-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #f0f0f0;
    }

    .card-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 10px 0;
    }

    .card-description {
        font-size: 14px;
        color: #7f8c8d;
        margin: 0 0 15px 0;
        line-height: 1.5;
        flex-grow: 1;
    }

    .card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12px;
        color: #95a5a6;
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid #ecf0f1;
    }

    .card-link {
        display: inline-block;
        color: #16a085;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .card-link:hover {
        color: #138d75;
        transform: translateX(3px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #7f8c8d;
    }

    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-fish {
        background: #e8f4f8;
        color: #16a085;
    }

    .badge-aquarium {
        background: #e8f8f4;
        color: #3498db;
    }

    .badge-terrarium {
        background: #f4f8e8;
        color: #27ae60;
    }

    .featured-section {
        margin-bottom: 60px;
    }

    @media (max-width: 768px) {
        .hero-section h1 {
            font-size: 32px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .card-container {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
    }
</style>

<div class="hero-section" data-aos="fade-up">
    <h1>🐠 Bienvenido a Acuario</h1>
    <p>Descubre un mundo fascinante de peces exóticos, acuarios y terrarios. Comparte tus experiencias y aprende de la comunidad.</p>
    <div class="hero-buttons">
        <a href="<?php echo APP_URL; ?>/aquarium" class="btn btn-light" style="border-radius: 50px; padding: 12px 30px; font-weight: 600;">
            <i class="fas fa-water"></i> Ver Acuarios
        </a>
        <a href="<?php echo APP_URL; ?>/articles" class="btn btn-light" style="border-radius: 50px; padding: 12px 30px; font-weight: 600;">
            <i class="fas fa-book"></i> Leer Artículos
        </a>
    </div>
</div>

<!-- Sección: Últimos Peces -->
<div class="featured-section">
    <div class="section-header">
        <h2><i class="fas fa-fish"></i> Últimos Peces</h2>
        <a href="<?php echo APP_URL; ?>/fish">Ver todos →</a>
    </div>

    <?php if (!empty($latestFish)): ?>
        <div class="card-container">
            <?php foreach ($latestFish as $fish): ?>
                <div class="feature-card" data-aos="fade-up">
                    <?php if ($fish['image_path']): ?>
                        <img src="<?php echo APP_URL; ?>/uploads/fish/<?php echo htmlspecialchars($fish['image_path']); ?>" 
                             class="card-image" alt="<?php echo htmlspecialchars($fish['name']); ?>">
                    <?php else: ?>
                        <div class="card-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-fish" style="font-size: 48px; color: white; opacity: 0.5;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-content">
                        <span class="badge badge-fish"><i class="fas fa-fish"></i> Pez</span>
                        <h3 class="card-title"><?php echo htmlspecialchars($fish['name']); ?></h3>
                        <p class="card-description">
                            <strong><?php echo htmlspecialchars($fish['scientific_name'] ?? 'N/A'); ?></strong><br>
                            Dificultad: 
                            <?php 
                                $difficulty = $fish['difficulty'] ?? 'Media';
                                $colors = ['Fácil' => '#27ae60', 'Media' => '#f39c12', 'Difícil' => '#e74c3c'];
                                $color = $colors[$difficulty] ?? '#95a5a6';
                            ?>
                            <span style="color: <?php echo $color; ?>;">●</span>
                            <?php echo ucfirst($difficulty); ?>
                        </p>
                        <div class="card-meta">
                            <span><i class="fas fa-temperature"></i> <?php echo htmlspecialchars($fish['temperature_min'] ?? '?'); ?>-<?php echo htmlspecialchars($fish['temperature_max'] ?? '?'); ?>°C</span>
                        </div>
                        <a href="<?php echo APP_URL; ?>/fish/show?id=<?php echo $fish['id']; ?>" class="card-link">
                            Ver ficha →
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
            <p>No hay peces registrados aún.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Sección: Últimos Acuarios -->
<div class="featured-section">
    <div class="section-header">
        <h2><i class="fas fa-water"></i> Últimos Acuarios</h2>
        <a href="<?php echo APP_URL; ?>/aquarium/public">Ver todos →</a>
    </div>

    <?php if (!empty($latestAquariums)): ?>
        <div class="card-container">
            <?php foreach ($latestAquariums as $aquarium): ?>
                <div class="feature-card" data-aos="fade-up">
                    <?php 
                        // Intentar obtener la primera foto de la galería
                        $firstPhoto = null;
                        if (!empty($aquarium['gallery_photos'])) {
                            $firstPhoto = $aquarium['gallery_photos'][0];
                        }
                    ?>
                    
                    <?php if ($firstPhoto): ?>
                        <?php 
                            // Verificar si es una URL o una ruta local
                            $imageSrc = (strpos($firstPhoto, 'http') === 0) 
                                ? $firstPhoto 
                                : APP_URL . '/uploads/gallery/' . htmlspecialchars($firstPhoto);
                        ?>
                        <img src="<?php echo $imageSrc; ?>" 
                             class="card-image" alt="<?php echo htmlspecialchars($aquarium['name']); ?>" onerror="this.style.display='none';">
                    <?php else: ?>
                        <div class="card-image" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-water" style="font-size: 48px; color: white; opacity: 0.5;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-content">
                        <span class="badge badge-aquarium"><i class="fas fa-water"></i> Acuario</span>
                        <h3 class="card-title"><?php echo htmlspecialchars($aquarium['name']); ?></h3>
                        <p class="card-description">
                            <?php echo htmlspecialchars(substr($aquarium['description'] ?? 'Sin descripción', 0, 60)); ?>...
                        </p>
                        <div class="card-meta">
                            <span><i class="fas fa-tint"></i> <?php echo htmlspecialchars($aquarium['volume_liters']); ?>L</span>
                            <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($aquarium['username']); ?></span>
                        </div>
                        <a href="<?php echo APP_URL; ?>/aquarium/public-show?id=<?php echo $aquarium['id']; ?>" class="card-link">
                            Ver acuario →
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
            <p>No hay acuarios publicados aún.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Sección: Últimos Terrarios -->
<div class="featured-section">
    <div class="section-header">
        <h2><i class="fas fa-leaf"></i> Últimos Terrarios</h2>
        <a href="<?php echo APP_URL; ?>/terrarium/public">Ver todos →</a>
    </div>

    <?php if (!empty($latestTerrariums)): ?>
        <div class="card-container">
            <?php foreach ($latestTerrariums as $terrarium): ?>
                <div class="feature-card" data-aos="fade-up">
                    <?php 
                        // Intentar obtener la primera foto de la galería
                        $firstPhoto = null;
                        if (!empty($terrarium['gallery_photos'])) {
                            $firstPhoto = $terrarium['gallery_photos'][0];
                        }
                    ?>
                    
                    <?php if ($firstPhoto): ?>
                        <?php 
                            // Verificar si es una URL o una ruta local
                            $imageSrc = (strpos($firstPhoto, 'http') === 0) 
                                ? $firstPhoto 
                                : APP_URL . '/uploads/gallery/' . htmlspecialchars($firstPhoto);
                        ?>
                        <img src="<?php echo $imageSrc; ?>" 
                             class="card-image" alt="<?php echo htmlspecialchars($terrarium['name']); ?>" onerror="this.style.display='none';">
                    <?php else: ?>
                        <div class="card-image" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-leaf" style="font-size: 48px; color: white; opacity: 0.5;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-content">
                        <span class="badge badge-terrarium"><i class="fas fa-leaf"></i> Terrario</span>
                        <h3 class="card-title"><?php echo htmlspecialchars($terrarium['name']); ?></h3>
                        <p class="card-description">
                            <?php echo htmlspecialchars(substr($terrarium['description'] ?? 'Sin descripción', 0, 60)); ?>...
                        </p>
                        <div class="card-meta">
                            <span><i class="fas fa-cube"></i> <?php echo htmlspecialchars($terrarium['volume_liters']); ?>L</span>
                            <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($terrarium['username']); ?></span>
                        </div>
                        <a href="<?php echo APP_URL; ?>/terrarium/public-show?id=<?php echo $terrarium['id']; ?>" class="card-link">
                            Ver terrario →
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
            <p>No hay terrarios publicados aún.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Sección: Últimos Artículos -->
<div class="featured-section">
    <div class="section-header">
        <h2><i class="fas fa-book"></i> Últimos Artículos</h2>
        <a href="<?php echo APP_URL; ?>/articles">Ver todos →</a>
    </div>

    <?php if (!empty($latestArticles)): ?>
        <div class="card-container">
            <?php foreach ($latestArticles as $article): ?>
                <div class="feature-card" data-aos="fade-up">
                    <?php if ($article['image_path']): ?>
                        <img src="<?php echo APP_URL; ?>/uploads/articles/<?php echo htmlspecialchars($article['image_path']); ?>" 
                             class="card-image" alt="<?php echo htmlspecialchars($article['title']); ?>">
                    <?php else: ?>
                        <div class="card-image" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-book" style="font-size: 48px; color: white; opacity: 0.5;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-content">
                        <span class="badge" style="background: #fef5e7; color: #e67e22;"><i class="fas fa-tag"></i> <?php echo htmlspecialchars($article['category']); ?></span>
                        <h3 class="card-title"><?php echo htmlspecialchars($article['title']); ?></h3>
                        <p class="card-description">
                            <?php echo htmlspecialchars(substr($article['description'] ?? $article['content'], 0, 80)); ?>...
                        </p>
                        <div class="card-meta">
                            <span><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($article['created_at'])); ?></span>
                            <span><i class="fas fa-eye"></i> <?php echo $article['views']; ?></span>
                        </div>
                        <a href="<?php echo APP_URL; ?>/articles/show?id=<?php echo $article['id']; ?>" class="card-link">
                            Leer artículo →
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
            <p>No hay artículos publicados aún.</p>
        </div>
    <?php endif; ?>
</div>
