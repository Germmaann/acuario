<h2>Panel Administrativo</h2>

<div class="grid">
    <div class="card">
        <h3 style="font-size: 32px; color: #667eea; margin-bottom: 10px;"><?php echo $stats['total_users']; ?></h3>
        <p><strong>Usuarios Totales</strong></p>
    </div>

    <div class="card">
        <h3 style="font-size: 32px; color: #667eea; margin-bottom: 10px;"><?php echo $stats['pending_fish']; ?></h3>
        <p><strong>Fichas Pendientes</strong></p>
    </div>

    <div class="card">
        <h3 style="font-size: 32px; color: #667eea; margin-bottom: 10px;"><?php echo $stats['reports']; ?></h3>
        <p><strong>Reportes Totales</strong></p>
    </div>

    <div class="card">
        <h3 style="font-size: 32px; color: #ff6b6b; margin-bottom: 10px;"><?php echo $stats['new_reports']; ?></h3>
        <p><strong>Reportes Nuevos</strong></p>
    </div>
</div>

<h3 style="margin-top: 30px;">Acciones Rápidas</h3>
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <a href="<?php echo APP_URL; ?>/admin/fish" class="btn btn-primary" style="padding: 15px; text-align: center; text-decoration: none;">Moderar Fichas</a>
    <a href="<?php echo APP_URL; ?>/admin/reports" class="btn btn-primary" style="padding: 15px; text-align: center; text-decoration: none;">Ver Reportes</a>
    <a href="<?php echo APP_URL; ?>/admin/users" class="btn btn-primary" style="padding: 15px; text-align: center; text-decoration: none;">Gestionar Usuarios</a>
</div>
