<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border-radius: 15px;">
                <div class="card-body py-5 text-white text-center">
                    <h1 style="font-weight: 700; font-size: 36px; margin-bottom: 10px;">
                        <i class="fas fa-water"></i> Crear Nuevo Acuario
                    </h1>
                    <p style="font-size: 16px; opacity: 0.9; margin-bottom: 0;">Configura tu acuario con estilo y claridad</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row" data-aos="fade-up">
        <div class="col-lg-10 offset-lg-1">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-5">
                    <form id="aquariumForm" method="POST" action="<?php echo APP_URL; ?>/aquarium/create">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

                        <!-- Información Básica -->
                        <div style="margin-bottom: 30px;">
                            <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #16a085;">
                                <i class="fas fa-info-circle"></i> Información Básica
                            </h4>
                            <div class="row" style="overflow: visible;">
                                <div class="col-12 col-md-6 mb-4">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Nombre del Acuario <span style="color: #e74c3c;">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Ej: Acuario Amazónico" required>
                                    <small style="color: #7f8c8d; display: block; margin-top: 5px;"><i class="fas fa-lightbulb"></i> Escoge un nombre único</small>
                                </div>
                                <div class="col-12 col-md-6 mb-4">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Tipo de Acuario <span style="color: #e74c3c;">*</span></label>
                                    <select name="type" class="form-control" required>
                                        <option value="">Seleccionar tipo</option>
                                        <option value="agua_dulce">💧 Agua Dulce</option>
                                        <option value="agua_salada">🌊 Agua Salada</option>
                                        <option value="brackish">🌿 Brackish</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Descripción (opcional)</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Describe el propósito y características del acuario..."></textarea>
                            </div>
                        </div>

                        <!-- Dimensiones -->
                        <div style="margin-bottom: 30px;">
                            <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #3498db;">
                                <i class="fas fa-expand"></i> Dimensiones
                            </h4>
                            <div class="row" style="overflow: visible;">
                                <div class="col-12 col-md-3 mb-4">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Largo (cm) <span style="color: #e74c3c;">*</span></label>
                                    <input type="number" name="dimensions_length" class="form-control" placeholder="Ej: 80" step="0.1" required>
                                </div>
                                <div class="col-12 col-md-3 mb-4">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Ancho (cm) <span style="color: #e74c3c;">*</span></label>
                                    <input type="number" name="dimensions_width" class="form-control" placeholder="Ej: 40" step="0.1" required>
                                </div>
                                <div class="col-12 col-md-3 mb-4">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Alto (cm) <span style="color: #e74c3c;">*</span></label>
                                    <input type="number" name="dimensions_height" class="form-control" placeholder="Ej: 50" step="0.1" required>
                                </div>
                                <div class="col-12 col-md-3 mb-4">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Capacidad (Litros) <span style="color: #e74c3c;">*</span></label>
                                    <input type="number" name="volume_liters" class="form-control" placeholder="Ej: 160" step="0.1" required>
                                </div>
                            </div>
                            <div style="background: #ecf0f1; padding: 12px 15px; border-radius: 8px; margin-top: 15px;">
                                <small style="color: #34495e;"><i class="fas fa-calculator"></i> Fórmula: (Largo × Ancho × Alto) ÷ 1000 = Litros</small>
                            </div>
                        </div>

                        <!-- Equipamiento e Iluminación -->
                        <div style="margin-bottom: 30px;">
                            <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #27ae60;">
                                <i class="fas fa-sliders-h"></i> Equipamiento e Iluminación
                            </h4>
                            <div class="row" style="overflow: visible;">
                                <div class="col-12 col-md-6 mb-4">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Horas de Luz al Día</label>
                                    <input type="number" name="lighting_hours" class="form-control" placeholder="Ej: 8" min="0" max="24" value="8" step="0.5">
                                </div>
                                <div class="col-12 col-md-6 mb-4">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Tipo de Filtro (opcional)</label>
                                    <input type="text" name="filter_type" class="form-control" placeholder="Ej: Eheim, Fluval...">
                                </div>
                            </div>
                            <div class="row" style="overflow: visible; margin-top: 5px;">
                                <div class="col-12 col-md-6 mb-4">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Opciones</label>
                                    <div style="background: #f8f9fa; padding: 12px 15px; border-radius: 8px;">
                                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                            <input type="checkbox" name="co2_injection">
                                            <span>Inyección de CO2</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 40px; padding-top: 20px; border-top: 1px solid #ecf0f1;">
                            <a href="<?php echo APP_URL; ?>/aquarium" class="btn btn-secondary" style="border-radius: 50px; padding: 12px 30px; font-weight: 600;">
                                <i class="fas fa-times-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 50px; padding: 12px 40px; font-weight: 600; background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border: none;">
                                <i class="fas fa-check-circle"></i> Crear Acuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tips -->
    <div class="row mt-5" data-aos="fade-up">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: #ecf0f1; border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 style="font-weight: 700; color: #2c3e50; margin-bottom: 15px;"><i class="fas fa-question-circle"></i> Consejos para tu acuario</h5>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
                        <div>
                            <h6 style="font-weight: 700; color: #16a085; margin-bottom: 8px;"><i class="fas fa-leaf"></i> Plantado</h6>
                            <p style="margin: 0; color: #34495e; font-size: 14px;">Ajusta la iluminación y fertilización según las plantas. Considera CO2 en acuarios densamente plantados.</p>
                        </div>
                        <div>
                            <h6 style="font-weight: 700; color: #3498db; margin-bottom: 8px;"><i class="fas fa-water"></i> Filtración</h6>
                            <p style="margin: 0; color: #34495e; font-size: 14px;">Mantén el filtro con flujo adecuado y limpieza regular para evitar bloqueos.</p>
                        </div>
                        <div>
                            <h6 style="font-weight: 700; color: #27ae60; margin-bottom: 8px;"><i class="fas fa-sun"></i> Iluminación</h6>
                            <p style="margin: 0; color: #34495e; font-size: 14px;">Usa 6–10 h de luz diaria en dulce, ajusta según algas y crecimiento.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('aquariumForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const response = await fetch('<?php echo APP_URL; ?>/aquarium/create', { method: 'POST', body: formData });
    const data = await response.json();
    if (data.success) {
        alert('Acuario creado!');
        location.href = '<?php echo APP_URL; ?>/aquarium/show?id=' + data.aquarium_id;
    } else {
        alert('Error: ' + data.message);
    }
});
</script>

<style>
.form-control {
    min-height: 44px;
    padding: 12px 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
    transition: all 0.3s;
    font-size: 16px;
}
.form-control:focus {
    border-color: #16a085;
    box-shadow: 0 0 0 0.2rem rgba(22, 160, 133, 0.25);
}
select.form-control {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2316a085' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    appearance: none;
    padding-right: 40px;
}
textarea.form-control { resize: vertical; }
.btn-primary { box-shadow: 0 4px 15px rgba(22, 160, 133, 0.3); }
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(22, 160, 133, 0.4); color: white; }
.btn-secondary { background: #95a5a6; border: none; color: white; }
.btn-secondary:hover { background: #7f8c8d; color: white; }
@media (max-width: 768px) { .card-body { padding: 20px !important; } }
</style>
