<style>
    .article-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .article-header {
        margin-bottom: 40px;
    }

    .article-category-badge {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .category-diy { background: #fef5e7; color: #d68910; }
    .category-blog { background: #fdeef4; color: #c0392b; }
    .category-evento { background: #eafaf1; color: #16a085; }

    .article-title {
        font-size: 42px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 20px 0;
        line-height: 1.2;
    }

    .article-metadata {
        display: flex;
        flex-wrap: wrap;
        gap: 25px;
        color: #7f8c8d;
        font-size: 14px;
        border-bottom: 2px solid #ecf0f1;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .meta-item i {
        color: #e67e22;
    }

    .author-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .author-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 14px;
    }

    .article-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }

    .article-body {
        font-size: 16px;
        line-height: 1.8;
        color: #2c3e50;
    }

    .article-body h2 {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin: 40px 0 20px 0;
        border-left: 4px solid #e67e22;
        padding-left: 15px;
    }

    .article-body h3 {
        font-size: 22px;
        font-weight: 700;
        color: #34495e;
        margin: 30px 0 15px 0;
    }

    .article-body p {
        margin-bottom: 20px;
        text-align: justify;
    }

    .article-body ul, .article-body ol {
        margin: 20px 0;
        padding-left: 30px;
    }

    .article-body li {
        margin-bottom: 10px;
    }

    .article-body blockquote {
        border-left: 4px solid #e67e22;
        padding: 20px;
        margin: 30px 0;
        background: #fef5e7;
        border-radius: 8px;
        font-style: italic;
        color: #7f8c8d;
    }

    .article-footer {
        margin-top: 50px;
        padding-top: 30px;
        border-top: 2px solid #ecf0f1;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .btn-secondary {
        padding: 12px 24px;
        border-radius: 25px;
        background: white;
        border: 2px solid #e67e22;
        color: #e67e22;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-secondary:hover {
        background: #e67e22;
        color: white;
    }

    .related-articles {
        margin-top: 50px;
        padding-top: 30px;
        border-top: 2px solid #ecf0f1;
    }

    .related-articles h3 {
        font-size: 24px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 25px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .related-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .related-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
    }

    .related-content {
        padding: 15px;
    }

    .related-title {
        font-size: 15px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0 0 8px 0;
        line-height: 1.3;
    }

    .related-link {
        display: inline-block;
        color: #e67e22;
        text-decoration: none;
        font-weight: 600;
        font-size: 13px;
        margin-top: 8px;
    }

    @media (max-width: 768px) {
        .article-title {
            font-size: 28px;
        }

        .article-metadata {
            flex-direction: column;
            gap: 15px;
        }

        .article-image {
            height: 250px;
        }

        .article-body {
            font-size: 15px;
        }
    }
</style>

<div class="article-container" data-aos="fade-up">
    <div class="article-header">
        <span class="article-category-badge category-<?php echo strtolower($article['category']); ?>">
            <?php echo htmlspecialchars($article['category']); ?>
        </span>
        
        <h1 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h1>
        
        <div class="article-metadata">
            <div class="meta-item author-info">
                <div class="author-avatar">
                    <?php echo strtoupper(substr($article['username'], 0, 1)); ?>
                </div>
                <div>
                    <strong><?php echo htmlspecialchars($article['username']); ?></strong><br>
                    <small>Autor</small>
                </div>
            </div>
            
            <div class="meta-item">
                <i class="fas fa-calendar"></i>
                <?php echo date('d de F de Y', strtotime($article['created_at'])); ?>
            </div>
            
            <div class="meta-item">
                <i class="fas fa-eye"></i>
                <?php echo $article['views']; ?> vistas
            </div>
            
            <?php if ($article['updated_at'] !== $article['created_at']): ?>
                <div class="meta-item">
                    <i class="fas fa-edit"></i>
                    Actualizado: <?php echo date('d/m/Y', strtotime($article['updated_at'])); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($article['image_path']): ?>
        <img src="<?php echo APP_URL; ?>/uploads/articles/<?php echo htmlspecialchars($article['image_path']); ?>" 
             class="article-image" alt="<?php echo htmlspecialchars($article['title']); ?>">
    <?php endif; ?>

    <div class="article-body">
        <?php echo $article['content']; ?>
    </div>

    <div class="article-footer">
        <div class="action-buttons">
            <a href="<?php echo APP_URL; ?>/articles" class="btn-secondary">
                ← Volver a artículos
            </a>
            <a href="<?php echo APP_URL; ?>/articles/category?category=<?php echo urlencode($article['category']); ?>" class="btn-secondary">
                Ver más de <?php echo htmlspecialchars($article['category']); ?>
            </a>
            <?php if (Session::get('role_id') == 1): ?>
                <button class="btn-secondary" onclick="editArticle(<?php echo $article['id']; ?>)">
                    <i class="fas fa-edit"></i> Editar
                </button>
                <button class="btn-secondary" style="border-color: #e74c3c; color: #e74c3c;" onclick="deleteArticle(<?php echo $article['id']; ?>)">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    function editArticle(id) {
        // Implementar edición de artículos
        window.location.href = '<?php echo APP_URL; ?>/articles/edit?id=' + id;
    }

    function deleteArticle(id) {
        if (!confirm('¿Eliminar este artículo?')) return;

        fetch('<?php echo APP_URL; ?>/articles/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + id
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = '<?php echo APP_URL; ?>/articles';
            } else {
                alert(data.message || 'Error al eliminar');
            }
        });
    }
</script>
