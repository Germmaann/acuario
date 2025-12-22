<h2>Moderación de Fichas de Peces</h2>

<!-- Pestañas de filtro -->
<div style="margin: 20px 0; border-bottom: 2px solid #eee;">
    <div style="display: flex; gap: 10px;">
        <?php
        $currentFilter = $_GET['filter'] ?? 'pendiente';
        $filters = [
            'pendiente' => '⏳ Pendientes',
            'aprobado' => '✅ Aprobados',
            'rechazado' => '❌ Rechazados',
            'todos' => '📋 Todos'
        ];
        
        foreach ($filters as $key => $label):
            $active = ($currentFilter === $key) ? 'background: #667eea; color: white;' : 'background: #f8f9fa; color: #333;';
            $count = $counts[$key] ?? 0;
        ?>
            <a href="<?php echo APP_URL; ?>/admin/moderate-fish?filter=<?php echo $key; ?>" 
               style="padding: 12px 20px; text-decoration: none; border-radius: 8px 8px 0 0; font-weight: 500; <?php echo $active; ?> transition: all 0.3s;">
                <?php echo $label; ?> <span style="background: rgba(255,255,255,0.2); padding: 2px 8px; border-radius: 10px; font-size: 12px;"><?php echo $count; ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<?php if (empty($fishes)): ?>
    <p style="text-align: center; padding: 40px; color: #999;">
        <?php 
        if ($currentFilter === 'pendiente') {
            echo 'No hay fichas pendientes de moderación.';
        } elseif ($currentFilter === 'aprobado') {
            echo 'No hay fichas aprobadas.';
        } elseif ($currentFilter === 'rechazado') {
            echo 'No hay fichas rechazadas.';
        } else {
            echo 'No hay fichas registradas.';
        }
        ?>
    </p>
<?php else: ?>
    <?php foreach ($fishes as $fish): ?>
        <div class="card" style="margin-bottom: 20px; <?php 
            if ($fish['status'] === 'aprobado') echo 'border-left: 4px solid #28a745;';
            elseif ($fish['status'] === 'rechazado') echo 'border-left: 4px solid #dc3545;';
            else echo 'border-left: 4px solid #ffc107;';
        ?>">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <h3><?php echo htmlspecialchars($fish['common_name']); ?></h3>
                    <p style="color: #666; margin: 5px 0;"><em><?php echo htmlspecialchars($fish['scientific_name']); ?></em></p>
                    <p style="color: #999; font-size: 13px;">
                        Autor: <strong><?php echo htmlspecialchars($fish['author_fullname']); ?></strong>
                        <?php if ($fish['status'] === 'aprobado'): ?>
                            <span style="margin-left: 10px; padding: 3px 10px; background: #28a745; color: white; border-radius: 12px; font-size: 11px;">✅ Aprobado</span>
                        <?php elseif ($fish['status'] === 'rechazado'): ?>
                            <span style="margin-left: 10px; padding: 3px 10px; background: #dc3545; color: white; border-radius: 12px; font-size: 11px;">❌ Rechazado</span>
                        <?php else: ?>
                            <span style="margin-left: 10px; padding: 3px 10px; background: #ffc107; color: #333; border-radius: 12px; font-size: 11px;">⏳ Pendiente</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div>
                    <form id="form-<?php echo $fish['id']; ?>" style="display: flex; gap: 10px;">
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(Security::generateCsrfToken()); ?>">
                        <input type="hidden" name="fish_id" value="<?php echo $fish['id']; ?>">
                        
                        <button type="button" onclick="previewFish(<?php echo $fish['id']; ?>)" class="btn" style="padding: 8px 15px; font-size: 14px; background: #6c757d; color: white;">👁️ Previsualizar</button>
                        
                        <?php if ($fish['status'] !== 'aprobado'): ?>
                        <button type="button" onclick="approveFish(<?php echo $fish['id']; ?>)" class="btn btn-primary" style="padding: 8px 15px; font-size: 14px;">✓ Aprobar</button>
                        <?php endif; ?>
                        
                        <?php if ($fish['status'] !== 'rechazado'): ?>
                        <button type="button" onclick="rejectFish(<?php echo $fish['id']; ?>)" class="btn btn-secondary" style="padding: 8px 15px; font-size: 14px;">✗ Rechazar</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            <p style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee;">
                <strong>Descripción:</strong> <?php echo htmlspecialchars($fish['description']); ?>
            </p>
            
            <?php if ($fish['status'] === 'rechazado' && !empty($fish['rejection_reason'])): ?>
            <div style="margin-top: 10px; padding: 10px; background: #fff3cd; border-left: 3px solid #ffc107; border-radius: 4px;">
                <strong>Motivo del rechazo:</strong> <?php echo htmlspecialchars($fish['rejection_reason']); ?>
            </div>
            <?php endif; ?>
            
            <!-- Modal de previsualización -->
            <div id="preview-<?php echo $fish['id']; ?>" class="preview-modal" style="display: none;">
                <div style="margin-top: 15px; padding: 15px; background: #f8f9fa; border-radius: 8px; border: 2px solid #667eea;">
                    <h4 style="margin: 0 0 15px 0; color: #667eea;">📋 Detalles Completos</h4>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 14px;">
                        <div>
                            <p><strong>Nombre común:</strong> <?php echo htmlspecialchars($fish['common_name']); ?></p>
                            <p><strong>Nombre científico:</strong> <em><?php echo htmlspecialchars($fish['scientific_name']); ?></em></p>
                            <?php if (!empty($fish['family'])): ?>
                            <p><strong>Familia:</strong> <?php echo htmlspecialchars($fish['family']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($fish['origin'])): ?>
                            <p><strong>Origen:</strong> <?php echo htmlspecialchars($fish['origin']); ?></p>
                            <?php endif; ?>
                            <p><strong>Dificultad:</strong> 
                                <?php 
                                $difficulty_labels = [
                                    'muy_fácil' => '⭐ Muy Fácil',
                                    'fácil' => '⭐⭐ Fácil',
                                    'medio' => '⭐⭐⭐ Medio',
                                    'difícil' => '⭐⭐⭐⭐ Difícil',
                                    'muy_difícil' => '⭐⭐⭐⭐⭐ Muy Difícil'
                                ];
                                echo $difficulty_labels[$fish['difficulty']] ?? $fish['difficulty'];
                                ?>
                            </p>
                        </div>
                        
                        <div>
                            <?php if ($fish['size_min'] || $fish['size_max']): ?>
                            <p><strong>Tamaño:</strong> <?php echo $fish['size_min']; ?>-<?php echo $fish['size_max']; ?> cm</p>
                            <?php endif; ?>
                            <?php if ($fish['temperature_min'] || $fish['temperature_max']): ?>
                            <p><strong>Temperatura:</strong> <?php echo $fish['temperature_min']; ?>-<?php echo $fish['temperature_max']; ?> °C</p>
                            <?php endif; ?>
                            <?php if ($fish['ph_min'] || $fish['ph_max']): ?>
                            <p><strong>pH:</strong> <?php echo $fish['ph_min']; ?>-<?php echo $fish['ph_max']; ?></p>
                            <?php endif; ?>
                            <?php if ($fish['hardness_min'] || $fish['hardness_max']): ?>
                            <p><strong>Dureza:</strong> <?php echo $fish['hardness_min']; ?>-<?php echo $fish['hardness_max']; ?> dGH</p>
                            <?php endif; ?>
                            <?php if (!empty($fish['lifespan'])): ?>
                            <p><strong>Esperanza de vida:</strong> <?php echo $fish['lifespan']; ?> años</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if (!empty($fish['behavior'])): ?>
                    <p style="margin-top: 10px;"><strong>Comportamiento:</strong> <?php echo htmlspecialchars($fish['behavior']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($fish['compatibility'])): ?>
                    <p><strong>Compatibilidad:</strong> <?php echo htmlspecialchars($fish['compatibility']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($fish['feeding'])): ?>
                    <p><strong>Alimentación:</strong> <?php echo htmlspecialchars($fish['feeding']); ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($fish['description'])): ?>
                    <p><strong>Descripción:</strong> <?php echo htmlspecialchars($fish['description']); ?></p>
                    <?php endif; ?>
                    
                    <button type="button" onclick="closePreview(<?php echo $fish['id']; ?>)" class="btn" style="margin-top: 15px; background: #6c757d; color: white;">Cerrar</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script>
function previewFish(fishId) {
    const preview = document.getElementById('preview-' + fishId);
    if (preview.style.display === 'none') {
        preview.style.display = 'block';
    } else {
        preview.style.display = 'none';
    }
}

function closePreview(fishId) {
    document.getElementById('preview-' + fishId).style.display = 'none';
}

function approveFish(fishId) {
    if (confirm('¿Aprobar esta ficha?')) {
        submitFishModeration(fishId, 'aprobado', '');
    }
}

function rejectFish(fishId) {
    const reason = prompt('¿Motivo del rechazo?');
    if (reason !== null) {
        submitFishModeration(fishId, 'rechazado', reason);
    }
}

async function submitFishModeration(fishId, status, reason) {
    const formData = new FormData();
    formData.append('csrf_token', document.querySelector('input[name="csrf_token"]').value);
    formData.append('fish_id', fishId);
    formData.append('status', status);
    formData.append('reason', reason);

    const response = await fetch('<?php echo APP_URL; ?>/admin/fish/status', {
        method: 'POST',
        body: formData
    });

    const data = await response.json();
    if (data.success) {
        location.reload();
    } else {
        alert('Error: ' + data.message);
    }
}
</script>
