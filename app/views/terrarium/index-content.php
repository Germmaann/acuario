<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #d35400 0%, #e67e22 100%); border-radius: 15px;">
                <div class="card-body text-center py-5 text-white">
                    <h1 style="font-weight: 700; font-size: 36px; margin-bottom: 10px;">
                        <i class="fas fa-leaf"></i> Mis Terrarios
                    </h1>
                    <p style="font-size: 18px; opacity: 0.9; margin-bottom: 20px;">Gestiona y organiza tus espacios naturales</p>
                    <a href="<?php echo APP_URL; ?>/terrarium/create" class="btn btn-light btn-lg" style="padding: 12px 35px; border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                        <i class="fas fa-plus-circle"></i> Crear Nuevo Terrario
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($terrariums)): ?>
        <!-- Empty State -->
        <div class="row" data-aos="fade-up">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body text-center py-5">
                        <div style="font-size: 100px; opacity: 0.2; margin-bottom: 20px;">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3 style="color: #666; margin-bottom: 15px;">Aún no tienes terrarios</h3>
                        <p style="color: #999; font-size: 16px; margin-bottom: 30px;">
                            Comienza creando tu primer terrario
                        </p>
                        <a href="<?php echo APP_URL; ?>/terrarium/create" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus-circle"></i> Crear Mi Primer Terrario
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Terrarium Grid -->
        <div class="row">
            <?php foreach ($terrariums as $index => $terrarium): ?>
                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; overflow: hidden; transition: all 0.3s;">
                        
                        <!-- Image Section -->
                        <div style="position: relative; overflow: hidden;">
                            <?php if ($terrarium['main_image']): ?>
                                <a href="<?php echo APP_URL; ?>/terrarium/show?id=<?php echo $terrarium['id']; ?>">
                                    <img src="<?php echo APP_URL; ?>/uploads/gallery/<?php echo htmlspecialchars($terrarium['main_image']); ?>" 
                                         style="width: 100%; height: 220px; object-fit: cover; transition: transform 0.3s;"
                                         onmouseover="this.style.transform='scale(1.1)'"
                                         onmouseout="this.style.transform='scale(1)'">
                                </a>
                            <?php else: ?>
                                <div style="width: 100%; height: 220px; background: linear-gradient(135deg, #d35400 0%, #e67e22 100%); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-leaf" style="font-size: 60px; color: rgba(255,255,255,0.5);"></i>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Status Badge -->
                            <div style="position: absolute; top: 15px; left: 15px;">
                                <?php 
                                    $statusColor = '#27ae60';
                                    $statusIcon = 'fa-play-circle';
                                    $statusText = 'Activo';
                                    
                                    if ($terrarium['status'] == 'inactivo') {
                                        $statusColor = '#e74c3c';
                                        $statusIcon = 'fa-pause-circle';
                                        $statusText = 'Inactivo';
                                    } elseif ($terrarium['status'] == 'en_construcción') {
                                        $statusColor = '#f39c12';
                                        $statusIcon = 'fa-tools';
                                        $statusText = 'En construcción';
                                    }
                                ?>
                                <span style="background: <?php echo $statusColor; ?>; 
                                             color: white; 
                                             padding: 6px 15px; 
                                             border-radius: 20px; 
                                             font-size: 12px; 
                                             font-weight: 700;
                                             box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
                                    <i class="fas <?php echo $statusIcon; ?>" style="font-size: 10px; margin-right: 5px;"></i><?php echo $statusText; ?>
                                </span>
                            </div>
                            
                            <!-- Delete Button -->
                            <div style="position: absolute; top: 15px; right: 15px;">
                                <form method="POST" action="<?php echo APP_URL; ?>/terrarium/delete" style="display: inline;">
                                    <input type="hidden" name="csrf_token" value="<?php echo Security::generateCsrfToken(); ?>">
                                    <input type="hidden" name="terrarium_id" value="<?php echo $terrarium['id']; ?>">
                                    <button type="submit" 
                                            style="background: rgba(231, 76, 60, 0.9); color: white; border: none; width: 35px; height: 35px; border-radius: 50%; cursor: pointer; font-size: 14px; transition: all 0.3s;"
                                            onmouseover="this.style.background='rgba(231, 76, 60, 1)'; this.style.transform='scale(1.1)';"
                                            onmouseout="this.style.background='rgba(231, 76, 60, 0.9)'; this.style.transform='scale(1)';"
                                            onclick="return confirm('¿Eliminar este terrario?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="card-body d-flex flex-column" style="flex-grow: 1;">
                            <h5 style="font-weight: 700; color: #2c3e50; margin-bottom: 10px;">
                                <?php echo htmlspecialchars($terrarium['name']); ?>
                            </h5>
                            
                            <?php if (!empty($terrarium['description'])): ?>
                                <p style="color: #7f8c8d; font-size: 14px; margin-bottom: 15px; flex-grow: 1;">
                                    <?php echo htmlspecialchars(substr($terrarium['description'], 0, 100)); ?>...
                                </p>
                            <?php endif; ?>

                            <!-- Info Cards -->
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
                                <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; text-align: center;">
                                    <small style="color: #7f8c8d; display: block; font-size: 11px; text-transform: uppercase;">Tipo</small>
                                    <strong style="color: #2c3e50; font-size: 13px;">
                                        <?php echo ucfirst(str_replace('_', ' ', $terrarium['type'])); ?>
                                    </strong>
                                </div>
                                <div style="background: #f8f9fa; padding: 12px; border-radius: 8px; text-align: center;">
                                    <small style="color: #7f8c8d; display: block; font-size: 11px; text-transform: uppercase;">Humedad</small>
                                    <strong style="color: #2c3e50; font-size: 13px;">
                                        <?php echo $terrarium['humidity_level']; ?>%
                                    </strong>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <a href="<?php echo APP_URL; ?>/terrarium/show?id=<?php echo $terrarium['id']; ?>" class="btn btn-primary" style="border-radius: 50px; width: 100%; font-weight: 600; margin-top: auto;">
                                <i class="fas fa-eye"></i> Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Stats Summary -->
        <div class="row mt-4" data-aos="fade-up">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body text-center py-4">
                        <h3 style="font-size: 32px; font-weight: 700; color: #e67e22; margin: 0;">
                            <?php echo count($terrariums); ?>
                        </h3>
                        <p style="color: #7f8c8d; margin: 0; margin-top: 5px; font-size: 14px;">Total de Terrarios</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body text-center py-4">
                        <h3 style="font-size: 32px; font-weight: 700; color: #27ae60; margin: 0;">
                            <?php echo count(array_filter($terrariums, fn($t) => $t['status'] === 'activo')); ?>
                        </h3>
                        <p style="color: #7f8c8d; margin: 0; margin-top: 5px; font-size: 14px;">Activos</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body text-center py-4">
                        <h3 style="font-size: 32px; font-weight: 700; color: #3498db; margin: 0;">
                            <?php echo array_sum(array_column($terrariums, 'volume_liters')); ?>L
                        </h3>
                        <p style="color: #7f8c8d; margin: 0; margin-top: 5px; font-size: 14px;">Capacidad Total</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Estilos AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
</script>

<style>
.btn-primary {
    background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
    border: none;
    color: white;
    padding: 10px 25px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(230, 126, 34, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(230, 126, 34, 0.4);
}
</style>
