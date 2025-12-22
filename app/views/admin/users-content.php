<h2>Gestión de Usuarios</h2>

<input type="hidden" id="csrf_token" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">

<table style="width: 100%; border-collapse: collapse;">
    <tr style="background: #f0f0f0; border-bottom: 2px solid #ddd;">
        <th style="padding: 10px; text-align: left;">Usuario</th>
        <th style="padding: 10px; text-align: left;">Email</th>
        <th style="padding: 10px;">Rol</th>
        <th style="padding: 10px;">Estado</th>
        <th style="padding: 10px;">Registrado</th>
        <th style="padding: 10px;">Acción</th>
    </tr>
    <?php foreach ($users as $user): ?>
        <tr style="border-bottom: 1px solid #eee;">
            <td style="padding: 10px;"><strong><?php echo htmlspecialchars($user['full_name']); ?></strong><br><small>@<?php echo htmlspecialchars($user['username']); ?></small></td>
            <td style="padding: 10px;"><?php echo htmlspecialchars($user['email']); ?></td>
            <td style="padding: 10px;">
                <select id="role_<?php echo $user['id']; ?>" onchange="changeUserRole(<?php echo $user['id']; ?>, this.value)" style="padding: 5px; border: 1px solid #ddd; border-radius: 3px; font-size: 12px;">
                    <?php foreach ($roles as $role): ?>
                        <option value="<?php echo $role['id']; ?>" <?php echo $role['id'] == $user['role_id'] ? 'selected' : ''; ?>>
                            <?php echo ucfirst($role['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td style="padding: 10px;">
                <span style="background: <?php echo $user['is_active'] ? '#6bcf7f' : '#ff6b6b'; ?>; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px;">
                    <?php echo $user['is_active'] ? 'Activo' : 'Inactivo'; ?>
                </span>
            </td>
            <td style="padding: 10px; font-size: 12px;"><?php echo $user['created_at']; ?></td>
            <td style="padding: 10px;">
                <?php if ($user['id'] !== Session::getUserId()): ?>
                    <button onclick="toggleUserStatus(<?php echo $user['id']; ?>, <?php echo $user['is_active'] ? 1 : 0; ?>)" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px;">
                        <?php echo $user['is_active'] ? 'Desactivar' : 'Activar'; ?>
                    </button>
                    <button onclick="deleteUserConfirm(<?php echo $user['id']; ?>, '<?php echo htmlspecialchars($user['full_name']); ?>')" class="btn btn-secondary" style="padding: 5px 10px; font-size: 12px; background: #ff6b6b; color: white;">
                        Eliminar
                    </button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<div style="margin-top: 20px; text-align: center;">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="btn <?php echo $i === (int)($_GET['page'] ?? 1) ? 'btn-primary' : 'btn-secondary'; ?>" style="margin: 5px; padding: 8px 12px; font-size: 14px;">
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
</div>

<script>
async function changeUserRole(userId, roleId) {
    const formData = new FormData();
    const csrfTokenElement = document.getElementById('csrf_token');
    if (!csrfTokenElement) {
        alert('Error: Token de seguridad no encontrado');
        return;
    }
    formData.append('csrf_token', csrfTokenElement.value);
    formData.append('user_id', userId);
    formData.append('role_id', roleId);

    const response = await fetch('<?php echo APP_URL; ?>/admin/users/role', {
        method: 'POST',
        body: formData
    });

    const data = await response.json();
    if (data.success) {
        // Mostrar confirmación sin recargar
        alert(data.message);
    } else {
        alert('Error: ' + data.message);
        // Revertir el cambio si hay error
        location.reload();
    }
}

async function toggleUserStatus(userId, currentActive) {
    const formData = new FormData();
    const csrfTokenElement = document.getElementById('csrf_token');
    if (!csrfTokenElement) {
        alert('Error: Token de seguridad no encontrado');
        return;
    }
    formData.append('csrf_token', csrfTokenElement.value);
    formData.append('user_id', userId);

    const response = await fetch('<?php echo APP_URL; ?>/admin/users/deactivate', {
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

async function deleteUserConfirm(userId, userName) {
    if (!confirm('¿Estás seguro de que quieres eliminar a ' + userName + '? Esta acción no se puede deshacer.')) {
        return;
    }

    const formData = new FormData();
    const csrfTokenElement = document.getElementById('csrf_token');
    if (!csrfTokenElement) {
        alert('Error: Token de seguridad no encontrado');
        return;
    }
    formData.append('csrf_token', csrfTokenElement.value);
    formData.append('user_id', userId);

    const response = await fetch('<?php echo APP_URL; ?>/admin/users/delete', {
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
