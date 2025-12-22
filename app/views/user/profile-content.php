<div style="display: grid; grid-template-columns: 300px 1fr; gap: 30px;">
    <!-- Columna izquierda: Foto de perfil -->
    <div>
        <div class="card">
            <h3 style="margin-bottom: 20px;"><?php echo __('user.profile.photo'); ?></h3>
            
            <div style="text-align: center; margin-bottom: 20px;">
                <?php if (!empty($user['avatar_path'])): ?>
                    <img src="<?php echo str_replace('public/', APP_URL . '/', $user['avatar_path']); ?>" 
                         alt="Avatar" 
                         style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; border: 4px solid #667eea;">
                <?php else: ?>
                    <div style="width: 200px; height: 200px; margin: 0 auto; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 64px; font-weight: bold;">
                        <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Formulario para subir foto -->
            <form method="POST" action="<?php echo APP_URL; ?>/user/upload-avatar" enctype="multipart/form-data">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;"><?php echo __('user.profile.change_photo'); ?>:</label>
                    <input type="file" name="avatar" accept="image/*" required 
                           style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 5px;">
                    <small style="color: #666;"><?php echo __('user.profile.photo_help'); ?></small>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%;"><?php echo __('user.profile.upload_photo'); ?></button>
            </form>

            <?php if (!empty($user['avatar_path'])): ?>
                <form method="POST" action="<?php echo APP_URL; ?>/user/remove-avatar" style="margin-top: 10px;">
                    <button type="submit" class="btn btn-secondary" style="width: 100%;" 
                            onclick="return confirm('<?php echo __('user.profile.confirm_delete_photo'); ?>')"><?php echo __('user.profile.delete_photo'); ?></button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Columna derecha: Información del perfil -->
    <div>
        <div class="card">
            <h3 style="margin-bottom: 20px;"><?php echo __('user.profile.info'); ?></h3>

            <div style="margin-bottom: 20px;">
                <p><strong><?php echo __('user.profile.username'); ?>:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong><?php echo __('user.profile.email'); ?>:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong><?php echo __('user.profile.full_name'); ?>:</strong> <?php echo htmlspecialchars($user['full_name'] ?? __('user.profile.not_set')); ?></p>
                <p><strong><?php echo __('user.profile.member_since'); ?>:</strong> <?php echo date('d/m/Y', strtotime($user['created_at'])); ?></p>
            </div>

            <!-- Formulario para actualizar información -->
            <form method="POST" action="<?php echo APP_URL; ?>/user/update-profile">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;"><?php echo __('user.profile.full_name'); ?>:</label>
                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" 
                           style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;"><?php echo __('user.profile.bio'); ?>:</label>
                    <textarea name="bio" rows="4" 
                              style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;"><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary"><?php echo __('user.profile.update'); ?></button>
            </form>
        </div>

        <!-- Estadísticas -->
        <div class="card" style="margin-top: 20px;">
            <h3 style="margin-bottom: 15px;"><?php echo __('user.profile.my_stats'); ?></h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; text-align: center;">
                <div style="padding: 15px; background: #f9f9f9; border-radius: 5px;">
                    <div style="font-size: 28px; font-weight: bold; color: #667eea;"><?php echo $stats['aquariums'] ?? 0; ?></div>
                    <div style="color: #666;"><?php echo __('user.profile.stats.aquariums'); ?></div>
                </div>
                <div style="padding: 15px; background: #f9f9f9; border-radius: 5px;">
                    <div style="font-size: 28px; font-weight: bold; color: #667eea;"><?php echo $stats['fish_contributed'] ?? 0; ?></div>
                    <div style="color: #666;"><?php echo __('user.profile.stats.fish_contributed'); ?></div>
                </div>
                <div style="padding: 15px; background: #f9f9f9; border-radius: 5px;">
                    <div style="font-size: 28px; font-weight: bold; color: #667eea;"><?php echo $stats['total_fish'] ?? 0; ?></div>
                    <div style="color: #666;"><?php echo __('user.profile.stats.total_fish'); ?></div>
                </div>
            </div>

            <div style="margin-top: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                <a href="<?php echo APP_URL; ?>/user/public-profile?id=<?php echo Session::getUserId(); ?>" class="btn btn-primary" style="text-align: center; display: block;">
                    🔗 <?php echo __('user.profile.view_public'); ?>
                </a>
                <a href="<?php echo APP_URL; ?>/user/change-password" class="btn btn-warning" style="text-align: center; display: block;">
                    🔐 <?php echo __('user.change_password'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
