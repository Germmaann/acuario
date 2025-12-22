<h2>Editar Ficha de Pez</h2>

<form id="fishEditForm" method="POST" action="<?php echo APP_URL; ?>/fish/update" enctype="multipart/form-data" style="max-width: 800px;">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
    <input type="hidden" name="fish_id" value="<?php echo (int)$fish['id']; ?>">

    <div class="grid" style="grid-template-columns: 1fr 1fr;">
        <div class="form-group">
            <label>Nombre Común (Requerido):</label>
            <input type="text" name="common_name" value="<?php echo htmlspecialchars($fish['common_name']); ?>" required>
        </div>

        <div class="form-group">
            <label>Nombre Científico:</label>
            <input type="text" name="scientific_name" value="<?php echo htmlspecialchars($fish['scientific_name'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Familia:</label>
            <input type="text" name="family" value="<?php echo htmlspecialchars($fish['family'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Origen:</label>
            <input type="text" name="origin" value="<?php echo htmlspecialchars($fish['origin'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Tamaño Mínimo (cm):</label>
            <input type="number" name="size_min" step="0.1" value="<?php echo htmlspecialchars($fish['size_min'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Tamaño Máximo (cm):</label>
            <input type="number" name="size_max" step="0.1" value="<?php echo htmlspecialchars($fish['size_max'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Temperatura Mínima (°C):</label>
            <input type="number" name="temperature_min" step="0.1" value="<?php echo htmlspecialchars($fish['temperature_min'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Temperatura Máxima (°C):</label>
            <input type="number" name="temperature_max" step="0.1" value="<?php echo htmlspecialchars($fish['temperature_max'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>PH Mínimo:</label>
            <input type="number" name="ph_min" step="0.1" value="<?php echo htmlspecialchars($fish['ph_min'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>PH Máximo:</label>
            <input type="number" name="ph_max" step="0.1" value="<?php echo htmlspecialchars($fish['ph_max'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Dureza Mínima (dGH):</label>
            <input type="number" name="hardness_min" step="0.1" value="<?php echo htmlspecialchars($fish['hardness_min'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Dureza Máxima (dGH):</label>
            <input type="number" name="hardness_max" step="0.1" value="<?php echo htmlspecialchars($fish['hardness_max'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label>Dificultad:</label>
            <select name="difficulty">
                <?php $diff = $fish['difficulty'] ?? DIFFICULTY_MEDIUM; ?>
                <option value="muy_fácil" <?php echo $diff === 'muy_fácil' ? 'selected' : ''; ?>>Muy Fácil</option>
                <option value="fácil" <?php echo $diff === 'fácil' ? 'selected' : ''; ?>>Fácil</option>
                <option value="medio" <?php echo $diff === 'medio' ? 'selected' : ''; ?>>Medio</option>
                <option value="difícil" <?php echo $diff === 'difícil' ? 'selected' : ''; ?>>Difícil</option>
                <option value="muy_difícil" <?php echo $diff === 'muy_difícil' ? 'selected' : ''; ?>>Muy Difícil</option>
            </select>
        </div>

        <div class="form-group">
            <label>Esperanza de Vida (años):</label>
            <input type="number" name="lifespan" step="0.1" value="<?php echo htmlspecialchars($fish['lifespan'] ?? ''); ?>">
        </div>
    </div>

    <div class="form-group">
        <label>Comportamiento:</label>
        <textarea name="behavior" placeholder="Describe el comportamiento del pez..."><?php echo htmlspecialchars($fish['behavior'] ?? ''); ?></textarea>
    </div>

    <div class="form-group">
        <label>Compatibilidad:</label>
        <textarea name="compatibility" placeholder="Describe con qué peces es compatible..."><?php echo htmlspecialchars($fish['compatibility'] ?? ''); ?></textarea>
    </div>

    <div class="form-group">
        <label>Alimentación:</label>
        <textarea name="feeding" placeholder="Describe su dieta..."><?php echo htmlspecialchars($fish['feeding'] ?? ''); ?></textarea>
    </div>

    <div class="form-group">
        <label>Descripción General:</label>
        <textarea name="description" placeholder="Descripción detallada del pez..."><?php echo htmlspecialchars($fish['description'] ?? ''); ?></textarea>
    </div>

    <div class="form-group">
        <label>Imagen Principal:</label>
        <?php if (!empty($fish['main_image'])): ?>
            <div style="margin-bottom: 10px;">
                <img src="<?php echo APP_URL; ?>/uploads/fish/<?php echo htmlspecialchars($fish['main_image']); ?>" alt="Imagen actual" style="max-width: 200px; border-radius: 6px;">
            </div>
        <?php endif; ?>
        <input type="file" name="main_image" accept="image/*">
        <small style="color: #666;">Si subes una nueva imagen, reemplazará la actual.</small>
    </div>

    <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 16px;">Guardar cambios</button>
</form>

<script>
document.getElementById('fishEditForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const response = await fetch('<?php echo APP_URL; ?>/fish/update', {
        method: 'POST',
        body: formData
    });
    const data = await response.json();
    if (data.success) {
        alert('Ficha actualizada');
        location.href = '<?php echo APP_URL; ?>/fish/show?id=' + <?php echo (int)$fish['id']; ?>;
    } else {
        alert('Error: ' + data.message);
    }
});
</script>
