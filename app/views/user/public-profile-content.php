<div style="max-width: 800px; margin: 0 auto;">
    <!-- Encabezado del perfil -->
    <div style="display: flex; gap: 20px; margin-bottom: 40px; align-items: flex-start;">
        <div style="flex: 0 0 150px;">
            <?php if (!empty($user['avatar_path'])): ?>
                <img src="<?php echo str_replace('public/', APP_URL . '/', $user['avatar_path']); ?>" 
                     alt="Avatar" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #667eea;">
            <?php else: ?>
                <div style="width: 150px; height: 150px; border-radius: 50%; background: #667eea; display: flex; align-items: center; justify-content: center; color: white; font-size: 60px; font-weight: bold;">
                    <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div style="flex: 1;">
            <h1 style="margin: 0 0 10px 0;"><?php echo htmlspecialchars($user['full_name']); ?></h1>
            <p style="color: #666; margin: 5px 0; font-size: 16px;">@<?php echo htmlspecialchars($user['username']); ?></p>
            
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-top: 20px;">
                <div style="background: #f0f0f0; padding: 12px; border-radius: 8px; text-align: center;">
                    <div style="font-size: 24px; font-weight: bold; color: #667eea;"><?php echo $stats['fish_contributed']; ?></div>
                    <div style="color: #666; font-size: 13px; margin-top: 5px;">Peces creados</div>
                </div>
                <div style="background: #f0f0f0; padding: 12px; border-radius: 8px; text-align: center;">
                    <div style="font-size: 24px; font-weight: bold; color: #667eea;"><?php echo $stats['aquariums']; ?></div>
                    <div style="color: #666; font-size: 13px; margin-top: 5px;">Acuarios públicos</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peces creados por el usuario -->
    <h2 style="border-bottom: 2px solid #667eea; padding-bottom: 10px; margin-bottom: 20px;">Peces Creados (<?php echo count($userFish); ?>)</h2>
    
    <?php if (empty($userFish)): ?>
        <p style="color: #999; text-align: center; padding: 30px;">Este usuario aún no ha creado fichas de peces.</p>
    <?php else: ?>
        <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px; margin-bottom: 40px;">
            <?php foreach ($userFish as $fish): ?>
                <a href="<?php echo APP_URL; ?>/fish/show?id=<?php echo $fish['id']; ?>" style="text-decoration: none; color: inherit;">
                    <div class="card" style="cursor: pointer; transition: transform 0.2s;">
                        <?php if ($fish['main_image']): ?>
                            <img src="<?php echo APP_URL; ?>/uploads/fish/<?php echo htmlspecialchars($fish['main_image']); ?>" 
                                 style="width: 100%; height: 140px; object-fit: cover; border-radius: 5px; margin-bottom: 10px;">
                        <?php else: ?>
                            <div style="width: 100%; height: 140px; background: #e0e0e0; border-radius: 5px; margin-bottom: 10px;"></div>
                        <?php endif; ?>
                        <h4 style="margin: 0 0 5px 0;"><?php echo htmlspecialchars($fish['common_name']); ?></h4>
                        <p style="font-size: 12px; color: #666; margin: 0;"><?php echo htmlspecialchars($fish['scientific_name'] ?? 'Sin clasificar'); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Acuarios del usuario -->
    <h2 style="border-bottom: 2px solid #667eea; padding-bottom: 10px; margin-bottom: 20px; margin-top: 40px;">Acuarios (<?php echo count($userAquariums); ?>)</h2>
    
    <?php if (empty($userAquariums)): ?>
        <p style="color: #999; text-align: center; padding: 30px;">Este usuario aún no ha creado acuarios.</p>
    <?php else: ?>
        <div class="grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-bottom: 40px;">
            <?php foreach ($userAquariums as $aquarium): ?>
                <a href="<?php echo APP_URL; ?>/aquarium/public-show?id=<?php echo $aquarium['id']; ?>" style="text-decoration: none; color: inherit;">
                    <div class="card" style="cursor: pointer; transition: transform 0.2s;">
                        <?php if ($aquarium['main_image']): ?>
                            <img src="<?php echo APP_URL; ?>/uploads/gallery/<?php echo htmlspecialchars($aquarium['main_image']); ?>" 
                                 style="width: 100%; height: 150px; object-fit: cover; border-radius: 5px; margin-bottom: 10px;">
                        <?php else: ?>
                            <div style="width: 100%; height: 150px; background: #e0e0e0; border-radius: 5px; margin-bottom: 10px;"></div>
                        <?php endif; ?>
                        <h4 style="margin: 0 0 5px 0;"><?php echo htmlspecialchars($aquarium['name']); ?></h4>
                        <p style="font-size: 12px; color: #666; margin: 0;"><?php echo $aquarium['volume_liters']; ?> L | <?php echo ucfirst(str_replace('_', ' ', $aquarium['type'])); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
