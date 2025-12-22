<style>
    .create-article-header {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        padding: 60px 20px;
        border-radius: 15px;
        margin-bottom: 40px;
        text-align: center;
    }

    .create-article-header h1 {
        font-size: 36px;
        font-weight: 700;
        margin: 0 0 15px 0;
    }

    .article-form-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .form-section {
        background: white;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .form-section-title {
        font-size: 20px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #ecf0f1;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="file"],
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px;
        border: 1px solid #bdc3c7;
        border-radius: 8px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="email"]:focus,
    .form-group input[type="file"]:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #e67e22;
        box-shadow: 0 0 0 3px rgba(230, 126, 34, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .editor-container {
        margin-bottom: 20px;
    }

    .editor-toolbar {
        display: flex;
        gap: 8px;
        padding: 12px;
        background: #f8f9fa;
        border: 1px solid #bdc3c7;
        border-bottom: none;
        border-radius: 8px 8px 0 0;
        flex-wrap: wrap;
    }

    .editor-btn {
        padding: 8px 12px;
        background: white;
        border: 1px solid #bdc3c7;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s;
        color: #2c3e50;
    }

    .editor-btn:hover {
        background: #e67e22;
        color: white;
        border-color: #e67e22;
    }

    #editor {
        width: 100%;
        min-height: 400px;
        padding: 15px;
        border: 1px solid #bdc3c7;
        border-radius: 0 0 8px 8px;
        font-size: 14px;
        font-family: 'Courier New', monospace;
        resize: vertical;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .checkbox-group label {
        margin: 0;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn-submit {
        padding: 14px 30px;
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 15px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(230, 126, 34, 0.3);
    }

    .btn-cancel {
        padding: 14px 30px;
        background: white;
        color: #e67e22;
        border: 2px solid #e67e22;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-cancel:hover {
        background: #e67e22;
        color: white;
    }

    .help-text {
        font-size: 12px;
        color: #7f8c8d;
        margin-top: 6px;
    }

    .image-preview {
        max-width: 200px;
        margin-top: 15px;
        border-radius: 8px;
        overflow: hidden;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-submit, .btn-cancel {
            width: 100%;
        }
    }
</style>

<div class="create-article-header" data-aos="fade-up">
    <h1><i class="fas fa-pen-fancy"></i> Crear Nuevo Artículo</h1>
</div>

<form id="articleForm" class="article-form-container" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo Session::get('csrf_token'); ?>">

    <!-- Información Básica -->
    <div class="form-section">
        <h3 class="form-section-title"><i class="fas fa-info-circle"></i> Información Básica</h3>

        <div class="form-group">
            <label for="title">Título del Artículo *</label>
            <input type="text" id="title" name="title" required placeholder="Ej: Cómo mantener peces tropicales">
            <small class="help-text">Mínimo 10 caracteres</small>
        </div>

        <div class="form-group">
            <label for="description">Descripción Breve *</label>
            <textarea id="description" name="description" required placeholder="Resumen de 150-160 caracteres que aparecerá en las listas"></textarea>
            <small class="help-text">Esta descripción aparecerá en las listas de artículos</small>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="category">Categoría *</label>
                <select id="category" name="category" required>
                    <option value="Blog">Blog</option>
                    <option value="DIY">DIY (Proyectos)</option>
                    <option value="Evento">Evento</option>
                </select>
            </div>

            <div class="form-group">
                <label for="image">Imagen Destacada</label>
                <input type="file" id="image" name="image" accept="image/*">
                <small class="help-text">JPG, PNG. Máx 5MB</small>
                <div id="imagePreview"></div>
            </div>
        </div>
    </div>

    <!-- Contenido -->
    <div class="form-section">
        <h3 class="form-section-title"><i class="fas fa-file-alt"></i> Contenido</h3>

        <div class="form-group">
            <label for="editor">Contenido Completo *</label>
            <div class="editor-toolbar">
                <button type="button" class="editor-btn" onclick="insertMarkdown('# ')"><strong>H1</strong></button>
                <button type="button" class="editor-btn" onclick="insertMarkdown('## ')"><strong>H2</strong></button>
                <button type="button" class="editor-btn" onclick="insertMarkdown('**', '**')"><i class="fas fa-bold"></i></button>
                <button type="button" class="editor-btn" onclick="insertMarkdown('_', '_')"><i class="fas fa-italic"></i></button>
                <button type="button" class="editor-btn" onclick="insertMarkdown('`', '`')"><i class="fas fa-code"></i></button>
                <button type="button" class="editor-btn" onclick="insertMarkdown('- ')">Bullet</button>
                <button type="button" class="editor-btn" onclick="insertMarkdown('> ')">Quote</button>
                <button type="button" class="editor-btn" onclick="insertMarkdown('[Link](url)')">[Link]</button>
            </div>
            <textarea id="editor" name="content" required placeholder="Escribe el contenido completo del artículo..."></textarea>
            <small class="help-text">Puedes usar HTML y Markdown básico. Acepta &lt;h2&gt;, &lt;h3&gt;, &lt;p&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;blockquote&gt;, etc.</small>
        </div>
    </div>

    <!-- Publicación -->
    <div class="form-section">
        <h3 class="form-section-title"><i class="fas fa-cog"></i> Opciones de Publicación</h3>

        <div class="checkbox-group">
            <input type="checkbox" id="is_published" name="is_published" value="1">
            <label for="is_published">Publicar inmediatamente</label>
        </div>
        <small class="help-text">Si no seleccionas esto, el artículo se guardará como borrador</small>
    </div>

    <!-- Acciones -->
    <div class="form-actions">
        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Crear Artículo</button>
        <a href="<?php echo APP_URL; ?>/articles" class="btn-cancel"><i class="fas fa-times"></i> Cancelar</a>
    </div>
</form>

<script>
    // Preview de imagen
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('imagePreview');
                preview.innerHTML = '<img src="' + event.target.result + '" class="image-preview">';
            };
            reader.readAsDataURL(file);
        }
    });

    // Insertar markdown en editor
    function insertMarkdown(before, after = '') {
        const editor = document.getElementById('editor');
        const start = editor.selectionStart;
        const end = editor.selectionEnd;
        const selected = editor.value.substring(start, end);
        const text = editor.value.substring(0, start) + before + selected + after + editor.value.substring(end);
        
        editor.value = text;
        editor.selectionStart = editor.selectionEnd = start + before.length + selected.length;
        editor.focus();
    }

    // Envío del formulario
    document.getElementById('articleForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('<?php echo APP_URL; ?>/articles/create', {
            method: 'POST',
            body: formData
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.href = '<?php echo APP_URL; ?>/articles/show?id=' + data.article_id;
            } else {
                alert(data.message || 'Error al crear artículo');
            }
        })
        .catch(err => {
            alert('Error: ' + err.message);
        });
    });
</script>
