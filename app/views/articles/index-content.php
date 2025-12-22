<style>
    .articles-header {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        padding: 60px 20px;
        border-radius: 15px;
        margin-bottom: 40px;
        text-align: center;
    }

    .articles-header h1 {
        font-size: 42px;
        font-weight: 700;
        margin: 0 0 15px 0;
    }

    .articles-header p {
        font-size: 16px;
        opacity: 0.95;
        margin: 0;
    }

    .category-filters {
        display: flex;
        gap: 10px;
        margin-bottom: 40px;
        flex-wrap: wrap;
    }

    .category-btn {
        padding: 10px 20px;
        border-radius: 25px;
        border: 2px solid #e67e22;
        background: white;
        color: #e67e22;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .category-btn:hover,
    .category-btn.active {
        background: #e67e22;
        color: white;
    }

    .articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .article-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .article-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .article-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }

    .article-content {
        padding: 25px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .article-category {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 12px;
        width: fit-content;
    }

    .category-diy { background: #fef5e7; color: #d68910; }
    .category-blog { background: #fdeef4; color: #c0392b; }
    .category-evento { background: #eafaf1; color: #16a085; }

    .article-title {
        font-size: 20px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 12px 0;
        line-height: 1.3;
    }

    .article-description {
        font-size: 14px;
        color: #7f8c8d;
        line-height: 1.6;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    .article-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: #95a5a6;
        padding-top: 15px;
        border-top: 1px solid #ecf0f1;
    }

    .article-author {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .article-link {
        display: inline-block;
        margin-top: 15px;
        color: #e67e22;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }

    .article-link:hover {
        color: #d35400;
        transform: translateX(3px);
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .pagination a, .pagination span {
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #ecf0f1;
        text-decoration: none;
        color: #2c3e50;
        transition: all 0.3s;
    }

    .pagination a:hover {
        background: #e67e22;
        color: white;
        border-color: #e67e22;
    }

    .pagination .current {
        background: #e67e22;
        color: white;
        border-color: #e67e22;
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
</style>

<div class="articles-header" data-aos="fade-up">
    <h1><i class="fas fa-book"></i> Centro de Conocimiento</h1>
    <p>Aprende sobre acuarismo, DIY y eventos de la comunidad</p>
</div>

<div class="category-filters">
    <a href="<?php echo APP_URL; ?>/articles" class="category-btn <?php echo !isset($_GET['category']) ? 'active' : ''; ?>">
        Todos los artículos
    </a>
    <a href="<?php echo APP_URL; ?>/articles/category?category=DIY" class="category-btn <?php echo isset($_GET['category']) && $_GET['category'] === 'DIY' ? 'active' : ''; ?>">
        <i class="fas fa-hammer"></i> DIY
    </a>
    <a href="<?php echo APP_URL; ?>/articles/category?category=Blog" class="category-btn <?php echo isset($_GET['category']) && $_GET['category'] === 'Blog' ? 'active' : ''; ?>">
        <i class="fas fa-pen-fancy"></i> Blog
    </a>
    <a href="<?php echo APP_URL; ?>/articles/category?category=Evento" class="category-btn <?php echo isset($_GET['category']) && $_GET['category'] === 'Evento' ? 'active' : ''; ?>">
        <i class="fas fa-calendar-alt"></i> Eventos
    </a>
    
    <?php if (Session::get('role_id') == 1): ?>
        <a href="<?php echo APP_URL; ?>/articles/create" class="btn btn-primary" style="border-radius: 25px; padding: 10px 20px; background: linear-gradient(135deg, #27ae60 0%, #229954 100%); border: none; color: white; text-decoration: none; font-weight: 600;">
            <i class="fas fa-plus"></i> Nuevo Artículo
        </a>
    <?php endif; ?>
</div>

<?php if (!empty($articles)): ?>
    <div class="articles-grid">
        <?php foreach ($articles as $article): ?>
            <div class="article-card" data-aos="fade-up">
                <?php if ($article['image_path']): ?>
                    <img src="<?php echo APP_URL; ?>/uploads/articles/<?php echo htmlspecialchars($article['image_path']); ?>" 
                         class="article-image" alt="<?php echo htmlspecialchars($article['title']); ?>">
                <?php else: ?>
                    <div class="article-image"></div>
                <?php endif; ?>
                
                <div class="article-content">
                    <span class="article-category category-<?php echo strtolower($article['category']); ?>">
                        <?php echo htmlspecialchars($article['category']); ?>
                    </span>
                    
                    <h3 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h3>
                    
                    <p class="article-description">
                        <?php echo htmlspecialchars(substr($article['description'] ?? $article['content'], 0, 120)); ?>...
                    </p>
                    
                    <div class="article-meta">
                        <div class="article-author">
                            <i class="fas fa-user-circle"></i>
                            <?php echo htmlspecialchars($article['username']); ?>
                        </div>
                        <span>
                            <i class="fas fa-eye"></i> <?php echo $article['views']; ?>
                        </span>
                    </div>
                    
                    <a href="<?php echo APP_URL; ?>/articles/show?id=<?php echo $article['id']; ?>" class="article-link">
                        Leer más →
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Paginación -->
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($page > 1): ?>
                <a href="<?php echo APP_URL; ?>/articles?page=<?php echo $page - 1; ?>">← Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <?php if ($i === $page): ?>
                    <span class="current"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="<?php echo APP_URL; ?>/articles?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="<?php echo APP_URL; ?>/articles?page=<?php echo $page + 1; ?>">Siguiente →</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="empty-state">
        <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
        <h3>No hay artículos disponibles</h3>
        <p>Vuelve pronto para nuevas publicaciones</p>
    </div>
<?php endif; ?>
