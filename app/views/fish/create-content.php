<h2>Crear Nueva Ficha de Pez</h2>

<form id="fishForm" method="POST" action="<?php echo APP_URL; ?>/fish/create" enctype="multipart/form-data" style="max-width: 800px;">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

    <div class="grid" style="grid-template-columns: 1fr 1fr;">
        <div class="form-group">
            <label>Nombre Común (Requerido):</label>
            <input type="text" name="common_name" required>
        </div>

        <div class="form-group">
            <label>Nombre Científico:</label>
            <input type="text" name="scientific_name">
        </div>

        <div class="form-group">
            <label>Familia:</label>
            <input type="text" name="family">
        </div>

        <div class="form-group">
            <label>Origen:</label>
            <input type="text" name="origin">
        </div>

        <div class="form-group">
            <label>Tamaño Mínimo (cm):</label>
            <input type="number" name="size_min" step="0.1">
        </div>

        <div class="form-group">
            <label>Tamaño Máximo (cm):</label>
            <input type="number" name="size_max" step="0.1">
        </div>

        <div class="form-group">
            <label>Temperatura Mínima (°C):</label>
            <input type="number" name="temperature_min" step="0.1" value="24">
        </div>

        <div class="form-group">
            <label>Temperatura Máxima (°C):</label>
            <input type="number" name="temperature_max" step="0.1" value="26">
        </div>

        <div class="form-group">
            <label>PH Mínimo:</label>
            <input type="number" name="ph_min" step="0.1" value="6.5">
        </div>

        <div class="form-group">
            <label>PH Máximo:</label>
            <input type="number" name="ph_max" step="0.1" value="7.5">
        </div>

        <div class="form-group">
            <label>Dureza Mínima (dGH):</label>
            <input type="number" name="hardness_min" step="0.1" value="5">
        </div>

        <div class="form-group">
            <label>Dureza Máxima (dGH):</label>
            <input type="number" name="hardness_max" step="0.1" value="20">
        </div>

        <div class="form-group">
            <label>Dificultad:</label>
            <select name="difficulty">
                <option value="muy_fácil">Muy Fácil</option>
                <option value="fácil">Fácil</option>
                <option value="medio" selected>Medio</option>
                <option value="difícil">Difícil</option>
                <option value="muy_difícil">Muy Difícil</option>
            </select>
        </div>

        <div class="form-group">
            <label>Esperanza de Vida (años):</label>
            <input type="number" name="lifespan" step="0.1">
        </div>
    </div>

    <div class="form-group">
        <label>Comportamiento:</label>
        <textarea name="behavior" placeholder="Describe el comportamiento del pez..."></textarea>
    </div>

    <div class="form-group">
        <label>Compatibilidad:</label>
        <textarea name="compatibility" placeholder="Describe con qué peces es compatible..."></textarea>
    </div>

    <div class="form-group">
        <label>Alimentación:</label>
        <textarea name="feeding" placeholder="Describe su dieta..."></textarea>
    </div>

    <div class="form-group">
        <label>Descripción General:</label>
        <textarea name="description" placeholder="Descripción detallada del pez..."></textarea>
    </div>

    <div class="form-group">
        <label>Imagen Principal:</label>
        <input type="file" name="main_image" accept="image/*">
    </div>

    <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 16px;">Crear Ficha</button>
</form>

<script>
document.getElementById('fishForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const response = await fetch('<?php echo APP_URL; ?>/fish/create', {
        method: 'POST',
        body: formData
    });

    const data = await response.json();
    if (data.success) {
        alert('Ficha creada! Pendiente de aprobación.');
        location.href = '<?php echo APP_URL; ?>/fish';
    } else {
        alert('Error: ' + data.message);
    }
});
</script>
