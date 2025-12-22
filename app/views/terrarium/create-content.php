<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #d35400 0%, #e67e22 100%); border-radius: 15px;">
                <div class="card-body py-5 text-white text-center">
                    <h1 style="font-weight: 700; font-size: 36px; margin-bottom: 10px;">
                        <i class="fas fa-leaf"></i> Crear Nuevo Terrario
                    </h1>
                    <p style="font-size: 16px; opacity: 0.9; margin-bottom: 0;">Configura tu espacio natural personalizado</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row" data-aos="fade-up">
        <div class="col-lg-10 offset-lg-1">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-body p-5">
                    <form method="POST" action="<?php echo APP_URL; ?>/terrarium/create">
                        <input type="hidden" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">

                        <!-- Basic Information Section -->
                        <div style="margin-bottom: 30px;">
                            <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #e67e22;">
                                <i class="fas fa-info-circle"></i> Información Básica
                            </h4>

                            <div class="row" style="overflow: visible;">
                                <div class="col-12 col-md-6 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Nombre del Terrario <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <input type="text" name="name" class="form-control" placeholder="Ej: Terrario Tropical A" required style="overflow: visible;">
                                    <small style="color: #7f8c8d; display: block; margin-top: 5px;">
                                        <i class="fas fa-lightbulb"></i> Elige un nombre descriptivo
                                    </small>
                                </div>

                                <div class="col-12 col-md-6 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Tipo de Terrario <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <select name="type" class="form-control" required style="overflow: visible;">
                                        <option value="">Seleccionar tipo</option>
                                        <option value="tropical">🌴 Tropical - Húmedo y cálido</option>
                                        <option value="desértico">🏜️ Desértico - Seco y cálido</option>
                                        <option value="subtropical">🌿 Subtropical - Templado y moderado</option>
                                        <option value="húmedo">💧 Húmedo - Alto nivel de humedad</option>
                                        <option value="seco">🌵 Seco - Bajo nivel de humedad</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">Descripción (opcional)</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Describe el propósito y características especiales del terrario..."></textarea>
                            </div>
                        </div>

                        <!-- Dimensions Section -->
                        <div style="margin-bottom: 30px;">
                            <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #3498db;">
                                <i class="fas fa-expand"></i> Dimensiones
                            </h4>

                            <div class="row" style="overflow: visible;">
                                <div class="col-12 col-md-3 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Largo (cm) <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <input type="number" name="length" class="form-control" placeholder="Ej: 80" step="0.1" required style="overflow: visible;">
                                </div>

                                <div class="col-12 col-md-3 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Ancho (cm) <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <input type="number" name="width" class="form-control" placeholder="Ej: 40" step="0.1" required style="overflow: visible;">
                                </div>

                                <div class="col-12 col-md-3 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Alto (cm) <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <input type="number" name="height" class="form-control" placeholder="Ej: 50" step="0.1" required style="overflow: visible;">
                                </div>

                                <div class="col-12 col-md-3 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Capacidad (Litros) <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <input type="number" name="volume_liters" class="form-control" placeholder="Ej: 160" step="0.1" required style="overflow: visible;">
                                </div>
                            </div>

                            <div style="background: #ecf0f1; padding: 12px 15px; border-radius: 8px; margin-top: 15px;">
                                <small style="color: #34495e;">
                                    <i class="fas fa-calculator"></i> 
                                    Fórmula: (Largo × Ancho × Alto) ÷ 1000 = Litros
                                </small>
                            </div>
                        </div>

                        <!-- Environment Section -->
                        <div style="margin-bottom: 30px;">
                            <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #27ae60;">
                                <i class="fas fa-sliders-h"></i> Condiciones Ambientales
                            </h4>

                            <div class="row" style="overflow: visible;">
                                <div class="col-12 col-md-6 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Rango de Temperatura (°C)
                                    </label>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                        <div>
                                            <label style="font-size: 13px; color: #7f8c8d; margin-bottom: 5px; display: block;">Mínima</label>
                                            <input type="number" name="temperature_min" class="form-control" placeholder="Ej: 20" step="0.1" value="20" style="overflow: visible;">
                                        </div>
                                        <div>
                                            <label style="font-size: 13px; color: #7f8c8d; margin-bottom: 5px; display: block;">Máxima</label>
                                            <input type="number" name="temperature_max" class="form-control" placeholder="Ej: 28" step="0.1" value="28" style="overflow: visible;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Nivel de Humedad (%) <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <input type="range" name="humidity_level" class="form-control-range" min="0" max="100" value="60" style="cursor: pointer; height: 8px; margin-top: 10px;">
                                    <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 12px; color: #7f8c8d;">
                                        <span>0%</span>
                                        <span id="humidityValue" style="font-weight: 700; color: #e67e22;">60%</span>
                                        <span>100%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="overflow: visible; margin-top: 15px;">
                                <div class="col-12 col-md-6 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Horas de Luz al Día
                                    </label>
                                    <input type="number" name="lighting_hours" class="form-control" placeholder="Ej: 12" min="0" max="24" value="12" step="0.5" style="overflow: visible;">
                                </div>

                                <div class="col-12 col-md-6 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Tipo de Calefacción (opcional)
                                    </label>
                                    <select name="heating_type" class="form-control" style="overflow: visible;">
                                        <option value="">Seleccionar</option>
                                        <option value="cable_calefactor">Cable calefactor</option>
                                        <option value="manta_calefactora">Manta calefactora</option>
                                        <option value="lampara_infrarroja">Lámpara infrarroja</option>
                                        <option value="lampara_ceramica">Lámpara cerámica</option>
                                        <option value="ninguna">Ninguna</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div style="margin-bottom: 30px;">
                            <h4 style="font-weight: 700; color: #2c3e50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f39c12;">
                                <i class="fas fa-toggle-on"></i> Estado
                            </h4>

                            <div class="row" style="overflow: visible;">
                                <div class="col-12 col-md-6 mb-4" style="overflow: visible;">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 10px; display: block;">
                                        Estado Inicial <span style="color: #e74c3c;">*</span>
                                    </label>
                                    <select name="status" class="form-control" required style="overflow: visible;">
                                        <option value="en_construcción">En construcción</option>
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 40px; padding-top: 20px; border-top: 1px solid #ecf0f1;">
                            <a href="<?php echo APP_URL; ?>/terrarium" class="btn btn-secondary" style="border-radius: 50px; padding: 12px 30px; font-weight: 600;">
                                <i class="fas fa-times-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary" style="border-radius: 50px; padding: 12px 40px; font-weight: 600; background: linear-gradient(135deg, #d35400 0%, #e67e22 100%); border: none;">
                                <i class="fas fa-check-circle"></i> Crear Terrario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="row mt-5" data-aos="fade-up">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: #ecf0f1; border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 style="font-weight: 700; color: #2c3e50; margin-bottom: 15px;">
                        <i class="fas fa-question-circle"></i> Consejos para crear tu terrario
                    </h5>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
                        <div>
                            <h6 style="font-weight: 700; color: #e67e22; margin-bottom: 8px;">
                                <i class="fas fa-thermometer"></i> Temperatura
                            </h6>
                            <p style="margin: 0; color: #34495e; font-size: 14px;">
                                Mantén un rango de temperatura adecuado según el tipo de terrario. Los terrarios tropicales requieren temperaturas más altas (24-28°C).
                            </p>
                        </div>
                        <div>
                            <h6 style="font-weight: 700; color: #3498db; margin-bottom: 8px;">
                                <i class="fas fa-water"></i> Humedad
                            </h6>
                            <p style="margin: 0; color: #34495e; font-size: 14px;">
                                La humedad varía según el tipo. Tropicales (70-80%), desérticos (30-40%), húmedos (80-90%).
                            </p>
                        </div>
                        <div>
                            <h6 style="font-weight: 700; color: #27ae60; margin-bottom: 8px;">
                                <i class="fas fa-sun"></i> Iluminación
                            </h6>
                            <p style="margin: 0; color: #34495e; font-size: 14px;">
                                La mayoría de habitantes necesitan 10-14 horas de luz al día. Ajusta según la especie.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });

    // Update humidity value display
    document.querySelector('input[name="humidity_level"]').addEventListener('input', function() {
        document.getElementById('humidityValue').textContent = this.value + '%';
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
    border-color: #e67e22;
    box-shadow: 0 0 0 0.2rem rgba(230, 126, 34, 0.25);
}

select.form-control {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23e67e22' d='M10.293 3.293L6 7.586 1.707 3.293A1 1 0 00.293 4.707l5 5a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    appearance: none;
    padding-right: 40px;
}

textarea.form-control {
    resize: vertical;
}

.form-control-range {
    width: 100%;
    accent-color: #e67e22;
}

.btn-primary {
    background: linear-gradient(135deg, #d35400 0%, #e67e22 100%);
    border: none;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(230, 126, 34, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(230, 126, 34, 0.4);
    color: white;
}

.btn-secondary {
    background: #95a5a6;
    border: none;
    color: white;
    transition: all 0.3s ease;
}

.btn-secondary:hover {
    background: #7f8c8d;
    color: white;
}

@media (max-width: 768px) {
    .card-body {
        padding: 20px !important;
    }
}
</style>
