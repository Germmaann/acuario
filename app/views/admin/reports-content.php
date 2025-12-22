<h2>Reportes de Errores en la Wiki</h2>

<!-- Pestañas de filtro -->
<div style="margin: 20px 0; border-bottom: 2px solid #eee;">
    <div style="display: flex; gap: 10px;">
        <?php
        $currentStatus = $_GET['status'] ?? '';
        $statusFilters = [
            '' => '📋 Todos',
            'nuevo' => '🔴 Nuevos',
            'en_revisión' => '🟡 En Revisión',
            'resuelto' => '🟢 Resueltos'
        ];
        
        foreach ($statusFilters as $key => $label):
            $active = ($currentStatus === $key) ? 'background: #667eea; color: white;' : 'background: #f8f9fa; color: #333;';
            $count = $key === '' ? $stats['total'] : ($key === 'nuevo' ? $stats['new'] : ($key === 'en_revisión' ? $stats['reviewing'] : $stats['resolved']));
        ?>
            <a href="<?php echo APP_URL; ?>/admin/reports?status=<?php echo $key; ?>" 
               style="padding: 12px 20px; text-decoration: none; border-radius: 8px 8px 0 0; font-weight: 500; <?php echo $active; ?> transition: all 0.3s;">
                <?php echo $label; ?> <span style="background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 10px; font-size: 12px;"><?php echo $count; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?php if (empty($reports)): ?>
    <p style="text-align: center; padding: 40px; color: #999;">No hay reportes en esta categoría.</p>
<?php else: ?>
    <?php foreach ($reports as $report): ?>
        <div class="card" style="margin-bottom: 20px; <?php 
            if ($report['status'] === 'resuelto') echo 'border-left: 4px solid #28a745;';
            elseif ($report['status'] === 'en_revisión') echo 'border-left: 4px solid #ffc107;';
            else echo 'border-left: 4px solid #dc3545;';
        ?>">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 15px;">
                <div>
                    <h3 style="margin: 0;">
                        <a href="<?php echo APP_URL; ?>/fish/show?id=<?php echo $report['fish_id']; ?>" 
                           style="color: #667eea; text-decoration: none;"
                           target="_blank">
                            <?php echo htmlspecialchars($report['fish_name'] ?? 'Pez no encontrado'); ?>
                        </a>
                    </h3>
                    <p style="color: #666; margin: 5px 0; font-size: 14px;">
                        Reportado por: <strong><?php echo htmlspecialchars($report['reporter_name']); ?></strong>
                    </p>
                    <p style="color: #999; font-size: 12px;">
                        <?php echo date('d/m/Y H:i', strtotime($report['created_at'])); ?>
                    </p>
                </div>
                <div>
                    <?php if ($report['status'] === 'resuelto'): ?>
                        <span style="padding: 8px 15px; background: #28a745; color: white; border-radius: 20px; font-size: 13px;">🟢 Resuelto</span>
                    <?php elseif ($report['status'] === 'en_revisión'): ?>
                        <span style="padding: 8px 15px; background: #ffc107; color: #333; border-radius: 20px; font-size: 13px;">🟡 En Revisión</span>
                    <?php else: ?>
                        <span style="padding: 8px 15px; background: #dc3545; color: white; border-radius: 20px; font-size: 13px;">🔴 Nuevo</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 15px;">
                <p style="margin: 0 0 8px 0;"><strong>Tipo de reporte:</strong> 
                    <span style="background: #667eea; color: white; padding: 3px 10px; border-radius: 12px; font-size: 12px;">
                        <?php 
                        $types = [
                            'datos_incorrectos' => '❌ Datos Incorrectos',
                            'compatibilidad' => '⚠️ Compatibilidad',
                            'imagen' => '🖼️ Imagen',
                            'otro' => '💬 Otro'
                        ];
                        echo $types[$report['report_type']] ?? ucfirst(str_replace('_', ' ', $report['report_type']));
                        ?>
                    </span>
                </p>
                <p style="margin: 8px 0 0 0;"><strong>Descripción del problema:</strong></p>
                <p style="margin: 5px 0; padding: 10px; background: white; border-radius: 4px; border-left: 3px solid #667eea;">
                    <?php echo nl2br(htmlspecialchars($report['comment'])); ?>
                </p>
            </div>
            
            <?php if (!empty($report['admin_response'])): ?>
            <div style="background: #e7f3ff; padding: 15px; border-radius: 6px; margin-bottom: 15px; border-left: 3px solid #0066cc;">
                <p style="margin: 0 0 5px 0; font-weight: bold; color: #0066cc;">💬 Respuesta del administrador:</p>
                <p style="margin: 0;"><?php echo nl2br(htmlspecialchars($report['admin_response'])); ?></p>
                <?php if (!empty($report['updated_at'])): ?>
                <p style="margin: 5px 0 0 0; font-size: 11px; color: #666;">
                    Actualizado el <?php echo date('d/m/Y H:i', strtotime($report['updated_at'])); ?>
                </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button onclick="viewFishDetail(<?php echo $report['fish_id']; ?>)" 
                        class="btn" 
                        style="padding: 8px 15px; background: #6c757d; color: white;">
                    👁️ Ver Pez
                </button>
                
                <?php if ($report['status'] !== 'resuelto'): ?>
                <button onclick="updateReportStatus(<?php echo $report['id']; ?>, 'en_revisión')" 
                        class="btn" 
                        style="padding: 8px 15px; background: #ffc107; color: #333;">
                    🟡 Marcar En Revisión
                </button>
                <button onclick="resolveReport(<?php echo $report['id']; ?>)" 
                        class="btn btn-primary" 
                        style="padding: 8px 15px;">
                    ✅ Resolver
                </button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<input type="hidden" id="csrf_token" value="<?php echo htmlspecialchars(Security::generateCsrfToken()); ?>">

<script>
function viewFishDetail(fishId) {
    window.open('<?php echo APP_URL; ?>/fish/show?id=' + fishId, '_blank');
}

async function updateReportStatus(reportId, status) {
    const response = prompt('Comentario/respuesta (opcional):');
    if (response === null) return;
    
    await submitReportUpdate(reportId, status, response);
}

async function resolveReport(reportId) {
    const response = prompt('Escribe la respuesta/solución aplicada:');
    if (response === null) return;
    if (!response.trim()) {
        alert('Debes escribir una respuesta para resolver el reporte.');
        return;
    }
    
    await submitReportUpdate(reportId, 'resuelto', response);
}

async function submitReportUpdate(reportId, status, response) {
    const formData = new FormData();
    formData.append('csrf_token', document.getElementById('csrf_token').value);
    formData.append('report_id', reportId);
    formData.append('status', status);
    formData.append('response', response);

    try {
        const res = await fetch('<?php echo APP_URL; ?>/admin/reports/status', {
            method: 'POST',
            body: formData
        });

        const data = await res.json();
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    } catch (error) {
        alert('Error al actualizar el reporte: ' + error.message);
    }
}
</script>
