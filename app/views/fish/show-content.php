<div style="display: flex; gap: 20px; margin-bottom: 30px;">
    <div style="flex: 0 0 300px;">
        <?php if ($fish['main_image']): ?>
            <img src="<?php echo APP_URL; ?>/uploads/fish/<?php echo htmlspecialchars($fish['main_image']); ?>" style="width: 100%; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <?php else: ?>
            <div style="width: 100%; height: 300px; background: #e0e0e0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999;">Sin imagen</div>
        <?php endif; ?>
    </div>

    <div style="flex: 1;">
        <h2><?php echo htmlspecialchars($fish['common_name']); ?></h2>
        <p style="font-size: 18px; color: #666; margin-bottom: 20px;"><em><?php echo htmlspecialchars($fish['scientific_name']); ?></em></p>

        <div class="grid" style="grid-template-columns: 1fr 1fr;">
            <div>
                <strong>Familia:</strong> <?php echo htmlspecialchars($fish['family'] ?? 'N/A'); ?><br>
                <strong>Origen:</strong> <?php echo htmlspecialchars($fish['origin'] ?? 'N/A'); ?><br>
                <strong>Tamaño:</strong> <?php echo $fish['size_min']; ?>-<?php echo $fish['size_max']; ?> cm<br>
                <strong>Esperanza de vida:</strong> <?php echo $fish['lifespan']; ?> años
            </div>
            <div>
                <strong>Temperatura:</strong> <?php echo $fish['temperature_min']; ?>-<?php echo $fish['temperature_max']; ?>°C<br>
                <strong>PH:</strong> <?php echo $fish['ph_min']; ?>-<?php echo $fish['ph_max']; ?><br>
                <strong>Dureza:</strong> <?php echo $fish['hardness_min']; ?>-<?php echo $fish['hardness_max']; ?> dGH<br>
                <strong>Dificultad:</strong> <span style="background: #667eea; color: white; padding: 2px 8px; border-radius: 3px;"><?php echo ucfirst(str_replace('_', ' ', $fish['difficulty'])); ?></span>
            </div>
        </div>

        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee; color: #666; font-size: 13px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <p style="margin: 0;">
                <strong>Registrado por:</strong> <?php echo htmlspecialchars($fish['author_fullname']); ?> (@<?php echo htmlspecialchars($fish['author_name']); ?>)
            </p>
            <?php if (Session::isLogged() && ($fish['author_id'] == Session::getUserId() || Session::isAdmin())): ?>
                <a href="<?php echo APP_URL; ?>/fish/edit?id=<?php echo $fish['id']; ?>" class="btn btn-primary" style="padding: 8px 14px; font-size: 13px;">Agregar datos</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card" style="border-left-color: #764ba2;">
    <h3>Comportamiento</h3>
    <p><?php echo nl2br(htmlspecialchars($fish['behavior'] ?? 'No especificado')); ?></p>
</div>

<div class="card" style="border-left-color: #764ba2; margin-top: 20px;">
    <h3>Compatibilidad</h3>
    <p><?php echo nl2br(htmlspecialchars($fish['compatibility'] ?? 'No especificada')); ?></p>
</div>

<div class="card" style="border-left-color: #764ba2; margin-top: 20px;">
    <h3>Alimentación</h3>
    <p><?php echo nl2br(htmlspecialchars($fish['feeding'] ?? 'No especificada')); ?></p>
</div>

<div class="card" style="border-left-color: #764ba2; margin-top: 20px;">
    <h3>Descripción</h3>
    <p><?php echo nl2br(htmlspecialchars($fish['description'] ?? 'Sin descripción')); ?></p>
</div>

<?php if (!empty($images)): ?>
    <h3 style="margin-top: 30px;">Galería de Imágenes</h3>
    <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));">
        <?php foreach ($images as $image): ?>
            <img src="<?php echo APP_URL; ?>/uploads/fish/<?php echo htmlspecialchars($image['image_path']); ?>" style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; cursor: pointer;" title="<?php echo htmlspecialchars($image['title'] ?? ''); ?>">
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php if (Session::isLogged()): ?>
    <button onclick="openReportModal()" class="btn btn-secondary" style="margin-top: 30px; padding: 10px 20px;">⚠ Reportar Error</button>

    <div id="reportModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 30px; border-radius: 8px; width: 90%; max-width: 500px;">
            <h3>Reportar Error</h3>
            <form id="reportForm">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(Security::generateCsrfToken()); ?>">
                <input type="hidden" name="fish_id" value="<?php echo $fish['id']; ?>">

                <div class="form-group">
                    <label>Tipo de Error:</label>
                    <select name="report_type" required>
                        <option value="">Seleccionar...</option>
                        <option value="datos_incorrectos">Datos Incorrectos</option>
                        <option value="compatibilidad">Compatibilidad</option>
                        <option value="imagen">Imagen</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Comentario:</label>
                    <textarea name="comment" required></textarea>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Enviar Reporte</button>
                    <button type="button" onclick="closeReportModal()" class="btn btn-secondary" style="flex: 1;">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function openReportModal() {
        document.getElementById('reportModal').style.display = 'block';
    }

    function closeReportModal() {
        document.getElementById('reportModal').style.display = 'none';
    }

    document.getElementById('reportForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        const response = await fetch('<?php echo APP_URL; ?>/fish/report', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        if (data.success) {
            alert(data.message);
            closeReportModal();
        } else {
            alert('Error: ' + data.message);
        }
    });
    </script>
<?php endif; ?>
