<div class="container-fluid">
    <!-- Header Section with Status Toggle -->
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #d35400 0%, #e67e22 100%); border-radius: 15px;">
                <div class="card-body py-4 text-white">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <h1 style="font-weight: 700; font-size: 32px; margin-bottom: 10px;">
                                <i class="fas fa-leaf"></i> <?php echo htmlspecialchars($terrarium['name']); ?>
                            </h1>
                            <p style="font-size: 16px; opacity: 0.9; margin-bottom: 0;">
                                Tipo: <strong><?php echo ucfirst(str_replace('_', ' ', $terrarium['type'])); ?></strong>
                            </p>
                        </div>
                        <div class="col-md-3 text-md-right text-center">
                            <button onclick="toggleTerrariumStatus()" class="btn btn-light btn-lg" style="padding: 10px 25px; border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                                <i class="fas <?php echo $terrarium['status'] === 'activo' ? 'fa-pause-circle' : 'fa-play-circle'; ?>"></i> 
                                <span id="statusBtnText"><?php echo $terrarium['status'] === 'activo' ? 'Desactivar' : 'Activar'; ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Cards Row -->
    <div class="row mb-4" data-aos="fade-up">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center py-4">
                    <h3 style="font-size: 28px; font-weight: 700; color: #e67e22; margin: 0;">
                        <?php echo $terrarium['volume_liters']; ?>L
                    </h3>
                    <p style="color: #7f8c8d; margin: 0; margin-top: 5px; font-size: 12px;">Capacidad</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center py-4">
                    <h3 style="font-size: 28px; font-weight: 700; color: #3498db; margin: 0;">
                        <?php echo $terrarium['temperature_min']; ?>°C - <?php echo $terrarium['temperature_max']; ?>°C
                    </h3>
                    <p style="color: #7f8c8d; margin: 0; margin-top: 5px; font-size: 12px;">Temperatura</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center py-4">
                    <h3 style="font-size: 28px; font-weight: 700; color: #27ae60; margin: 0;">
                        <?php echo $terrarium['humidity_level']; ?>%
                    </h3>
                    <p style="color: #7f8c8d; margin: 0; margin-top: 5px; font-size: 12px;">Humedad</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body text-center py-4">
                    <h3 style="font-size: 28px; font-weight: 700; color: #9b59b6; margin: 0;">
                        <?php echo count($inhabitants); ?>
                    </h3>
                    <p style="color: #7f8c8d; margin: 0; margin-top: 5px; font-size: 12px;">Habitantes</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Dimensions and Environment -->
    <div class="row mb-4" data-aos="fade-up">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header border-bottom-0" style="background: linear-gradient(135deg, #d35400 0%, #e67e22 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h5 style="margin: 0; font-weight: 700;"><i class="fas fa-expand"></i> Dimensiones</h5>
                </div>
                <div class="card-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                        <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <small style="color: #7f8c8d; display: block; text-transform: uppercase; font-size: 11px; margin-bottom: 5px;">Largo</small>
                            <strong style="font-size: 20px; color: #2c3e50;"><?php echo $terrarium['dimensions_length']; ?> cm</strong>
                        </div>
                        <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <small style="color: #7f8c8d; display: block; text-transform: uppercase; font-size: 11px; margin-bottom: 5px;">Ancho</small>
                            <strong style="font-size: 20px; color: #2c3e50;"><?php echo $terrarium['dimensions_width']; ?> cm</strong>
                        </div>
                        <div style="text-align: center; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <small style="color: #7f8c8d; display: block; text-transform: uppercase; font-size: 11px; margin-bottom: 5px;">Alto</small>
                            <strong style="font-size: 20px; color: #2c3e50;"><?php echo $terrarium['dimensions_height']; ?> cm</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header border-bottom-0" style="background: linear-gradient(135deg, #d35400 0%, #e67e22 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h5 style="margin: 0; font-weight: 700;"><i class="fas fa-sliders-h"></i> Ambiente</h5>
                </div>
                <div class="card-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <small style="color: #7f8c8d; display: block; text-transform: uppercase; font-size: 11px; margin-bottom: 5px;">Horas de Luz</small>
                            <strong style="font-size: 18px; color: #2c3e50;"><?php echo $terrarium['lighting_hours']; ?>h</strong>
                        </div>
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <small style="color: #7f8c8d; display: block; text-transform: uppercase; font-size: 11px; margin-bottom: 5px;">Tipo de Calefacción</small>
                            <strong style="font-size: 16px; color: #2c3e50;"><?php echo htmlspecialchars($terrarium['heating_type'] ?: 'N/A'); ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Inhabitants Section -->
    <div class="row mb-4" data-aos="fade-up">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header border-bottom-0" style="background: linear-gradient(135deg, #27ae60 0%, #16a085 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h5 style="margin: 0; font-weight: 700; cursor: pointer;" data-toggle="collapse" data-target="#inhabitantsForm">
                        <i class="fas fa-users"></i> Habitantes
                        <small style="opacity: 0.8;">(<?php echo count($inhabitants); ?> total)</small>
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Add Inhabitant Form -->
                    <div id="inhabitantsForm" class="collapse" style="margin-bottom: 20px; overflow: visible;">
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #27ae60; overflow: visible;">
                            <h6 style="margin-bottom: 15px; font-weight: 700; color: #2c3e50;">Agregar Habitante</h6>
                            <form method="POST" action="<?php echo APP_URL; ?>/terrarium/add-inhabitant">
                                <input type="hidden" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">
                                <input type="hidden" name="terrarium_id" value="<?php echo $terrarium['id']; ?>">
                                
                                <div class="row" style="overflow: visible;">
                                    <div class="col-12 col-md-4 mb-3" style="overflow: visible;">
                                        <label style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block;">Nombre</label>
                                        <input type="text" name="name" class="form-control" placeholder="Nombre del habitante" required style="overflow: visible;">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3" style="overflow: visible;">
                                        <label style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block;">Tipo</label>
                                        <select name="type" class="form-control" required style="overflow: visible;">
                                            <option value="">Seleccionar</option>
                                            <option value="reptil">Reptil</option>
                                            <option value="anfibio">Anfibio</option>
                                            <option value="insecto">Insecto</option>
                                            <option value="aracnido">Arácnido</option>
                                            <option value="planta">Planta</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-2 mb-3" style="overflow: visible;">
                                        <label style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block;">Cantidad</label>
                                        <input type="number" name="quantity" class="form-control" value="1" min="1" required style="overflow: visible;">
                                    </div>
                                    <div class="col-12 col-md-3 mb-3 d-flex align-items-end" style="overflow: visible;">
                                        <button type="submit" class="btn btn-success" style="width: 100%; border-radius: 50px; font-weight: 600;">
                                            <i class="fas fa-plus-circle"></i> Agregar
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block;">Notas</label>
                                    <textarea name="notes" class="form-control" rows="2" placeholder="Información adicional..."></textarea>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Inhabitants List -->
                    <?php if (empty($inhabitants)): ?>
                        <div style="text-align: center; padding: 30px; color: #7f8c8d;">
                            <i class="fas fa-info-circle" style="font-size: 24px; opacity: 0.5;"></i>
                            <p style="margin-top: 10px;">No hay habitantes registrados aún</p>
                        </div>
                    <?php else: ?>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
                            <?php foreach ($inhabitants as $inhabitant): ?>
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #27ae60;">
                                    <h6 style="font-weight: 700; color: #2c3e50; margin-bottom: 8px;">
                                        <?php echo htmlspecialchars($inhabitant['name']); ?>
                                    </h6>
                                    <p style="margin: 5px 0; color: #7f8c8d; font-size: 14px;">
                                        <strong>Tipo:</strong> <?php echo ucfirst($inhabitant['type']); ?>
                                    </p>
                                    <p style="margin: 5px 0; color: #7f8c8d; font-size: 14px;">
                                        <strong>Cantidad:</strong> <?php echo $inhabitant['quantity']; ?>
                                    </p>
                                    <?php if (!empty($inhabitant['notes'])): ?>
                                        <p style="margin: 5px 0; color: #7f8c8d; font-size: 12px;">
                                            <strong>Notas:</strong> <?php echo htmlspecialchars($inhabitant['notes']); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <div class="row mb-4" data-aos="fade-up">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header border-bottom-0" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h5 style="margin: 0; font-weight: 700; cursor: pointer;" data-toggle="collapse" data-target="#galleryForm">
                        <i class="fas fa-images"></i> Galería
                        <small style="opacity: 0.8;">(<?php echo count($gallery); ?> fotos)</small>
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Upload Form -->
                    <div id="galleryForm" class="collapse" style="margin-bottom: 20px;">
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #3498db;">
                            <h6 style="margin-bottom: 15px; font-weight: 700; color: #2c3e50;">Subir Foto</h6>
                            <form method="POST" action="<?php echo APP_URL; ?>/terrarium/upload-gallery" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">
                                <input type="hidden" name="terrarium_id" value="<?php echo $terrarium['id']; ?>">
                                
                                <div class="row">
                                    <div class="col-12 col-md-8 mb-3">
                                        <label style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block;">Imagen</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" required>
                                    </div>
                                    <div class="col-12 col-md-4 mb-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-info" style="width: 100%; border-radius: 50px; font-weight: 600;">
                                            <i class="fas fa-cloud-upload-alt"></i> Subir
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block;">Título (opcional)</label>
                                        <input type="text" name="title" class="form-control" placeholder="Título de la foto">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Gallery Grid -->
                    <?php if (empty($gallery)): ?>
                        <div style="text-align: center; padding: 30px; color: #7f8c8d;">
                            <i class="fas fa-image" style="font-size: 24px; opacity: 0.5;"></i>
                            <p style="margin-top: 10px;">No hay fotos en la galería</p>
                        </div>
                    <?php else: ?>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                            <?php foreach ($gallery as $photo): ?>
                                <div style="position: relative; border-radius: 8px; overflow: hidden;">
                                    <img src="<?php echo APP_URL; ?>/uploads/gallery/<?php echo htmlspecialchars($photo['image_path']); ?>" 
                                         style="width: 100%; height: 200px; object-fit: cover;">
                                    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s;" 
                                         onmouseover="this.style.opacity='1'" 
                                         onmouseout="this.style.opacity='0'">
                                        <button style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #e74c3c; color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-weight: 600;">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Log Section -->
    <div class="row mb-4" data-aos="fade-up">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header border-bottom-0" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h5 style="margin: 0; font-weight: 700; cursor: pointer;" data-toggle="collapse" data-target="#maintenanceForm">
                        <i class="fas fa-wrench"></i> Registro de Mantenimiento
                        <small style="opacity: 0.8;">(<?php echo count($maintenanceLogs); ?> registros)</small>
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Maintenance Form -->
                    <div id="maintenanceForm" class="collapse" style="margin-bottom: 20px;">
                        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #f39c12;">
                            <h6 style="margin-bottom: 15px; font-weight: 700; color: #2c3e50;">Agregar Registro</h6>
                            <form method="POST" action="<?php echo APP_URL; ?>/terrarium/log-maintenance">
                                <input type="hidden" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">
                                <input type="hidden" name="terrarium_id" value="<?php echo $terrarium['id']; ?>">
                                
                                <div class="row" style="overflow: visible;">
                                    <div class="col-12 col-md-4 mb-3" style="overflow: visible;">
                                        <label style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block;">Tipo de Mantenimiento</label>
                                        <select name="log_type" class="form-control" required style="overflow: visible;">
                                            <option value="">Seleccionar</option>
                                            <option value="limpieza">Limpieza</option>
                                            <option value="cambio_agua">Cambio de Agua</option>
                                            <option value="alimentacion">Alimentación</option>
                                            <option value="revision">Revisión General</option>
                                            <option value="reparacion">Reparación</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-8 mb-3" style="overflow: visible;">
                                        <label style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block;">Descripción</label>
                                        <input type="text" name="description" class="form-control" placeholder="Describir el mantenimiento realizado" required style="overflow: visible;">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
                                        <label style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block;">
                                            <input type="checkbox" name="reminder_enabled" value="1"> Habilitar recordatorio
                                        </label>
                                    </div>
                                    <div class="col-12 col-md-6 mb-3" id="reminderFields" style="display: none;">
                                        <label style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block;">Recordar cada (días)</label>
                                        <input type="number" name="reminder_days" class="form-control" min="1" value="30">
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-warning" style="border-radius: 50px; font-weight: 600; width: 100%;">
                                    <i class="fas fa-plus-circle"></i> Agregar Registro
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Maintenance Timeline -->
                    <?php if (empty($maintenanceLogs)): ?>
                        <div style="text-align: center; padding: 30px; color: #7f8c8d;">
                            <i class="fas fa-history" style="font-size: 24px; opacity: 0.5;"></i>
                            <p style="margin-top: 10px;">No hay registros de mantenimiento</p>
                        </div>
                    <?php else: ?>
                        <div style="position: relative; padding-left: 30px;">
                            <?php foreach ($maintenanceLogs as $index => $log): ?>
                                <div style="padding-bottom: 20px; position: relative;">
                                    <div style="position: absolute; left: -30px; width: 12px; height: 12px; background: #f39c12; border-radius: 50%; top: 5px;"></div>
                                    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 3px solid #f39c12;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                            <h6 style="margin: 0; font-weight: 700; color: #2c3e50;">
                                                <?php echo ucfirst(str_replace('_', ' ', $log['log_type'])); ?>
                                            </h6>
                                            <small style="color: #95a5a6;">
                                                <?php echo date('d/m/Y H:i', strtotime($log['created_at'])); ?>
                                            </small>
                                        </div>
                                        <p style="margin: 5px 0; color: #7f8c8d;">
                                            <?php echo htmlspecialchars($log['description']); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="row" data-aos="fade-up">
        <div class="col-12">
            <a href="<?php echo APP_URL; ?>/terrarium" class="btn btn-secondary" style="border-radius: 50px; font-weight: 600; padding: 12px 30px;">
                <i class="fas fa-arrow-left"></i> Volver a Terrarios
            </a>
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

    // Toggle reminder fields
    document.querySelector('input[name="reminder_enabled"]').addEventListener('change', function() {
        document.getElementById('reminderFields').style.display = this.checked ? 'block' : 'none';
    });

    // Toggle terrarium status
    function toggleTerrariumStatus() {
        if (!confirm('¿Estás seguro de que deseas cambiar el estado del terrario?')) return;

        fetch('<?php echo APP_URL; ?>/terrarium/toggle-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                terrarium_id: <?php echo $terrarium['id']; ?>,
                csrf_token: '<?php echo Security::generateCsrfToken(); ?>'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const newStatus = data.new_status;
                document.getElementById('statusBtnText').textContent = newStatus === 'activo' ? 'Desactivar' : 'Activar';
                location.reload();
            } else {
                alert('Error: ' + (data.message || 'Algo salió mal'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al cambiar el estado');
        });
    }
</script>

<style>
.form-control {
    min-height: 44px;
    padding: 12px 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
    transition: all 0.3s;
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

.btn-success {
    background: #27ae60;
    border: none;
    color: white;
    transition: all 0.3s;
}

.btn-success:hover {
    background: #229954;
    transform: translateY(-2px);
}

.btn-info {
    background: #3498db;
    border: none;
    color: white;
    transition: all 0.3s;
}

.btn-info:hover {
    background: #2980b9;
    transform: translateY(-2px);
}

.btn-warning {
    background: #f39c12;
    border: none;
    color: white;
    transition: all 0.3s;
}

.btn-warning:hover {
    background: #e67e22;
    transform: translateY(-2px);
}

.btn-secondary {
    background: #95a5a6;
    border: none;
    color: white;
    transition: all 0.3s;
}

.btn-secondary:hover {
    background: #7f8c8d;
    transform: translateY(-2px);
}
</style>
