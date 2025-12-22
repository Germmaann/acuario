<div class="container-fluid">
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #148f77 0%, #16a085 100%); border-radius: 15px;">
                <div class="card-body py-5 text-white text-center">
                    <h1 style="font-weight: 700; font-size: 36px; margin-bottom: 10px;">
                        <i class="fas fa-chart-line"></i> Dashboard de Acuarios
                    </h1>
                    <p style="font-size: 16px; opacity: 0.9; margin-bottom: 0;">Resumen y estadísticas de tus acuarios</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4" data-aos="fade-up">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-top: 4px solid #16a085;">
                <div class="card-body text-center py-4">
                    <i class="fas fa-water" style="font-size: 32px; color: #16a085; margin-bottom: 10px; display: block;"></i>
                    <h3 style="font-size: 32px; font-weight: 700; color: #2c3e50; margin: 0;">
                        <?php echo $statistics['total_aquariums'] ?? 0; ?>
                    </h3>
                    <p style="color: #7f8c8d; margin: 8px 0 0 0; font-size: 14px;">Total de Acuarios</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-top: 4px solid #27ae60;">
                <div class="card-body text-center py-4">
                    <i class="fas fa-play-circle" style="font-size: 32px; color: #27ae60; margin-bottom: 10px; display: block;"></i>
                    <h3 style="font-size: 32px; font-weight: 700; color: #2c3e50; margin: 0;">
                        <?php echo $statistics['active_aquariums'] ?? 0; ?>
                    </h3>
                    <p style="color: #7f8c8d; margin: 8px 0 0 0; font-size: 14px;">Activos</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-top: 4px solid #3498db;">
                <div class="card-body text-center py-4">
                    <i class="fas fa-cube" style="font-size: 32px; color: #3498db; margin-bottom: 10px; display: block;"></i>
                    <h3 style="font-size: 28px; font-weight: 700; color: #2c3e50; margin: 0;">
                        <?php echo round($statistics['total_capacity'] ?? 0, 0); ?>L
                    </h3>
                    <p style="color: #7f8c8d; margin: 8px 0 0 0; font-size: 14px;">Capacidad Total</p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm" style="border-radius: 12px; border-top: 4px solid #9b59b6;">
                <div class="card-body text-center py-4">
                    <i class="fas fa-lightbulb" style="font-size: 32px; color: #9b59b6; margin-bottom: 10px; display: block;"></i>
                    <h3 style="font-size: 24px; font-weight: 700; color: #2c3e50; margin: 0;">
                        <?php echo round($statistics['avg_lighting_hours'] ?? 0, 1); ?>h / día
                    </h3>
                    <p style="color: #7f8c8d; margin: 8px 0 0 0; font-size: 14px;">Iluminación Promedio</p>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($alerts)): ?>
    <div class="row mb-4" data-aos="fade-up">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header border-bottom-0" style="background: #fff3cd; color: #856404; border-radius: 12px 12px 0 0; padding: 15px;">
                    <h5 style="margin: 0; font-weight: 700;">
                        <i class="fas fa-exclamation-triangle"></i> Alertas de Mantenimiento
                    </h5>
                </div>
                <div class="card-body">
                    <?php foreach ($alerts as $alert): ?>
                        <div style="background: #fffbea; padding: 15px; border-radius: 8px; margin-bottom: 12px; border-left: 4px solid #f39c12;">
                            <div style="display: flex; justify-content: space-between; align-items: start;">
                                <div>
                                    <h6 style="margin: 0 0 8px 0; font-weight: 700; color: #2c3e50;">
                                        <a href="<?php echo APP_URL; ?>/aquarium/show?id=<?php echo $alert['aquarium_id']; ?>" style="color: #16a085; text-decoration: none;">
                                            <?php echo htmlspecialchars($alert['aquarium_name']); ?>
                                        </a>
                                    </h6>
                                    <p style="margin: 5px 0; color: #7f8c8d; font-size: 14px;">
                                        <strong><?php echo ucfirst(str_replace('_', ' ', $alert['log_type'])); ?>:</strong> <?php echo htmlspecialchars($alert['description']); ?>
                                    </p>
                                    <small style="color: #95a5a6;">
                                        Próximo: <?php echo date('d/m/Y', strtotime($alert['reminder_next_at'])); ?>
                                    </small>
                                </div>
                                <span style="background: <?php echo ($alert['days_remaining'] ?? 0) < 0 ? '#e74c3c' : '#f39c12'; ?>; color: white; padding: 8px 15px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                    <?php 
                                        $dr = (int)($alert['days_remaining'] ?? 0);
                                        if ($dr < 0) {
                                            echo 'Vencido ' . abs($dr) . 'd';
                                        } else {
                                            echo 'En ' . $dr . 'd';
                                        }
                                    ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row mb-4" data-aos="fade-up">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header border-bottom-0" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h5 style="margin: 0; font-weight: 700;">
                        <i class="fas fa-history"></i> Mantenimiento Reciente
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentMaintenance)): ?>
                        <?php foreach ($recentMaintenance as $maint): ?>
                            <div style="padding-bottom: 15px; border-bottom: 1px solid #ecf0f1; margin-bottom: 15px;">
                                <h6 style="margin: 0 0 5px 0; font-weight: 700; color: #2c3e50;">
                                    <?php echo ucfirst(str_replace('_', ' ', $maint['log_type'])); ?>
                                </h6>
                                <p style="margin: 5px 0; color: #7f8c8d; font-size: 13px;">
                                    <strong><?php echo htmlspecialchars($maint['aquarium_name']); ?></strong>
                                    <?php if (!empty($maint['percentage'])): ?>
                                        — Cambio de agua: <?php echo (int)$maint['percentage']; ?>%
                                    <?php endif; ?>
                                </p>
                                <small style="color: #95a5a6;">
                                    <?php echo date('d/m/Y H:i', strtotime($maint['created_at'])); ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #7f8c8d; text-align: center; padding: 20px 0;">
                            <i class="fas fa-info-circle"></i> Sin registros recientes
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header border-bottom-0" style="background: linear-gradient(135deg, #27ae60 0%, #16a085 100%); color: white; border-radius: 12px 12px 0 0;">
                    <h5 style="margin: 0; font-weight: 700;">
                        <i class="fas fa-lightning-bolt"></i> Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <a href="<?php echo APP_URL; ?>/aquarium/create" class="btn btn-primary" style="border-radius: 8px; padding: 15px; text-align: center; text-decoration: none; background: linear-gradient(135deg, #148f77 0%, #16a085 100%); color: white; font-weight: 600;">
                            <i class="fas fa-plus-circle"></i><br>
                            <small>Crear Acuario</small>
                        </a>
                        <a href="<?php echo APP_URL; ?>/aquarium/gallery" class="btn btn-info" style="border-radius: 8px; padding: 15px; text-align: center; text-decoration: none; background: #3498db; color: white; font-weight: 600;">
                            <i class="fas fa-images"></i><br>
                            <small>Ver Galería</small>
                        </a>
                        <a href="<?php echo APP_URL; ?>/aquarium/search" class="btn btn-warning" style="border-radius: 8px; padding: 15px; text-align: center; text-decoration: none; background: #f39c12; color: white; font-weight: 600;">
                            <i class="fas fa-search"></i><br>
                            <small>Buscar</small>
                        </a>
                        <a href="<?php echo APP_URL; ?>/aquarium" class="btn btn-success" style="border-radius: 8px; padding: 15px; text-align: center; text-decoration: none; background: #27ae60; color: white; font-weight: 600;">
                            <i class="fas fa-list"></i><br>
                            <small>Mis Acuarios</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 100
    });
</script>
