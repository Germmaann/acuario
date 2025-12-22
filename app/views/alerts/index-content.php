<div class="container-fluid">
    <div class="row mb-4" data-aos="fade-down">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%); border-radius: 15px;">
                <div class="card-body py-5 text-white text-center">
                    <h1 style="font-weight: 700; font-size: 32px; margin-bottom: 10px;">
                        <i class="fas fa-bell"></i> Notificaciones y Alertas
                    </h1>
                    <p style="font-size: 16px; opacity: 0.9; margin-bottom: 0;">Mantenimientos próximos o vencidos en tus módulos</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row" data-aos="fade-up">
        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header border-bottom-0" style="background: #fff3cd; color: #856404; border-radius: 12px 12px 0 0;">
                    <h5 style="margin: 0; font-weight: 700;"><i class="fas fa-water"></i> Acuarios</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($aquariumAlerts)): ?>
                        <?php foreach ($aquariumAlerts as $alert): ?>
                            <div style="background: #fffbea; padding: 15px; border-radius: 8px; margin-bottom: 12px; border-left: 4px solid #f39c12;">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <h6 style="margin: 0 0 8px 0; font-weight: 700; color: #2c3e50;">
                                            <a href="<?php echo APP_URL; ?>/aquarium/show?id=<?php echo $alert['aquarium_id']; ?>" style="color: #16a085; text-decoration: none;">
                                                <?php echo htmlspecialchars($alert['aquarium_name']); ?>
                                            </a>
                                        </h6>
                                        <p style="margin: 5px 0; color: #7f8c8d; font-size: 14px;">
                                            <strong><?php echo ucfirst(str_replace('_', ' ', $alert['log_type'])); ?>:</strong> <?php echo htmlspecialchars($alert['description'] ?? ''); ?>
                                        </p>
                                        <small style="color: #95a5a6;">Próximo: <?php echo date('d/m/Y', strtotime($alert['reminder_next_at'])); ?></small>
                                    </div>
                                    <span style="background: <?php echo ($alert['days_remaining'] ?? 0) < 0 ? '#e74c3c' : '#f39c12'; ?>; color: white; padding: 8px 15px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                        <?php $dr = (int)($alert['days_remaining'] ?? 0); echo $dr < 0 ? ('Vencido ' . abs($dr) . 'd') : ('En ' . $dr . 'd'); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #7f8c8d;"><i class="fas fa-info-circle"></i> No hay alertas de acuarios</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header border-bottom-0" style="background: #fff3cd; color: #856404; border-radius: 12px 12px 0 0;">
                    <h5 style="margin: 0; font-weight: 700;"><i class="fas fa-leaf"></i> Terrarios</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($terrariumAlerts)): ?>
                        <?php foreach ($terrariumAlerts as $alert): ?>
                            <div style="background: #fffbea; padding: 15px; border-radius: 8px; margin-bottom: 12px; border-left: 4px solid #f39c12;">
                                <div style="display: flex; justify-content: space-between; align-items: start;">
                                    <div>
                                        <h6 style="margin: 0 0 8px 0; font-weight: 700; color: #2c3e50;">
                                            <a href="<?php echo APP_URL; ?>/terrarium/show?id=<?php echo $alert['terrarium_id']; ?>" style="color: #e67e22; text-decoration: none;">
                                                <?php echo htmlspecialchars($alert['terrarium_name']); ?>
                                            </a>
                                        </h6>
                                        <p style="margin: 5px 0; color: #7f8c8d; font-size: 14px;">
                                            <strong><?php echo ucfirst(str_replace('_', ' ', $alert['log_type'])); ?>:</strong> <?php echo htmlspecialchars($alert['description'] ?? ''); ?>
                                        </p>
                                        <small style="color: #95a5a6;">Realizado: <?php echo date('d/m/Y', strtotime($alert['created_at'])); ?></small>
                                    </div>
                                    <span style="background: <?php echo $alert['days_remaining'] < 0 ? '#e74c3c' : '#f39c12'; ?>; color: white; padding: 8px 15px; border-radius: 20px; font-weight: 600; font-size: 12px;">
                                        <?php echo $alert['days_remaining'] < 0 ? ('Vencido ' . abs($alert['days_remaining']) . 'd') : ('En ' . $alert['days_remaining'] . 'd'); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="color: #7f8c8d;"><i class="fas fa-info-circle"></i> No hay alertas de terrarios</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 100 });
</script>
