<?php
// Inicializar variables por si no están definidas
$aquariums = $aquariums ?? [];
$totalPages = $totalPages ?? 1;
$pageTitle = $pageTitle ?? 'Acuarios Públicos';
$isPublicView = $isPublicView ?? true;
?>

<style>
    .aquariums-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .aquarium-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .aquarium-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .aquarium-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    }

    .aquarium-content {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .aquarium-title {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 10px 0;
    }

    .aquarium-description {
        font-size: 14px;
        color: #7f8c8d;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    .aquarium-meta {
        display: flex;
        gap: 10px;
        font-size: 12px;
        color: #95a5a6;
        margin-bottom: 15px;
    }

    .aquarium-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .aquarium-owner {
        font-size: 12px;
        color: #3498db;
        margin-bottom: 15px;
    }

    .aquarium-link {
        background: #3498db;
        color: white;
        padding: 10px 15px;
        border-radius: 6px;
        text-decoration: none;
        text-align: center;
        font-weight: 600;
        transition: all 0.3s;
    }

    .aquarium-link:hover {
        background: #2980b9;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 40px;
    }

    .pagination a, .pagination span {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #3498db;
        transition: all 0.3s;
    }

    .pagination a:hover {
        background: #ecf0f1;
    }

    .pagination .active {
        background: #3498db;
        color: white;
        border-color: #3498db;
    }

    .pagination .disabled {
        color: #bdc3c7;
        cursor: not-allowed;
    }

    @media (max-width: 768px) {
        .aquariums-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
        }
    }
</style>

<div class="container" style="padding: 40px 20px;">
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 36px; color: #2c3e50; margin-bottom: 10px;">🌊 Acuarios Públicos</h1>
        <p style="color: #7f8c8d; font-size: 16px;">Explora los acuarios de nuestra comunidad</p>
    </div>

    <?php if (!empty($aquariums)): ?>
        <div class="aquariums-grid">
            <?php foreach ($aquariums as $aquarium): ?>
                <div class="aquarium-card" data-aos="fade-up">
                    <?php 
                        $firstPhoto = null;
                        if (!empty($aquarium['gallery_photos'])) {
                            $firstPhoto = $aquarium['gallery_photos'][0];
                        }
                    ?>
                    
                    <?php if ($firstPhoto): ?>
                        <img src="<?php echo APP_URL; ?>/uploads/gallery/<?php echo htmlspecialchars($firstPhoto); ?>" 
                             class="aquarium-image" alt="<?php echo htmlspecialchars($aquarium['name']); ?>">
                    <?php else: ?>
                        <div class="aquarium-image" style="display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-water" style="font-size: 48px; color: white; opacity: 0.5;"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="aquarium-content">
                        <h3 class="aquarium-title"><?php echo htmlspecialchars($aquarium['name']); ?></h3>
                        <p class="aquarium-description">
                            <?php echo htmlspecialchars(substr($aquarium['description'] ?? 'Sin descripción', 0, 100)); ?>...
                        </p>
                        <div class="aquarium-meta">
                            <span><i class="fas fa-cube"></i> <?php echo htmlspecialchars($aquarium['volume_liters']); ?>L</span>
                            <span><i class="fas fa-droplet"></i> <?php echo ucfirst(str_replace('_', ' ', $aquarium['type'])); ?></span>
                        </div>
                        <div class="aquarium-owner">
                            <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($aquarium['username']); ?>
                        </div>
                        <a href="<?php echo APP_URL; ?>/aquarium/public-show?id=<?php echo $aquarium['id']; ?>" class="aquarium-link">
                            Ver detalles
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php 
                    $currentPage = (int)($_GET['page'] ?? 1);
                    
                    // Botón anterior
                    if ($currentPage > 1): ?>
                        <a href="<?php echo APP_URL; ?>/aquarium/public?page=<?php echo $currentPage - 1; ?>">← Anterior</a>
                    <?php else: ?>
                        <span class="disabled">← Anterior</span>
                    <?php endif; ?>
                    
                    <?php 
                    // Números de página
                    for ($i = 1; $i <= $totalPages; $i++): 
                        if ($i === $currentPage): ?>
                            <span class="active"><?php echo $i; ?></span>
                        <?php else: ?>
                            <a href="<?php echo APP_URL; ?>/aquarium/public?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>
                    
                    // Botón siguiente
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="<?php echo APP_URL; ?>/aquarium/public?page=<?php echo $currentPage + 1; ?>">Siguiente →</a>
                    <?php else: ?>
                        <span class="disabled">Siguiente →</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div style="text-align: center; padding: 40px; background: #ecf0f1; border-radius: 12px;">
            <i class="fas fa-inbox" style="font-size: 48px; color: #95a5a6; margin-bottom: 20px;"></i>
            <p style="color: #7f8c8d; font-size: 16px;">No hay acuarios públicos aún.</p>
        </div>
    <?php endif; ?>
</div>
