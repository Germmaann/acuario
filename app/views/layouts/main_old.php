<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - ' : ''; ?><?php echo APP_NAME; ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            border-radius: 8px;
        }
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            text-decoration: none;
        }
        nav { display: flex; gap: 20px; align-items: center; }
        nav a {
            text-decoration: none;
            color: #666;
            font-weight: 500;
            transition: color 0.3s;
        }
        nav a:hover { color: #667eea; }
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #667eea;
        }
        .user-avatar-placeholder {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover { background: #764ba2; }
        .btn-secondary {
            background: #f0f0f0;
            color: #333;
        }
        .btn-secondary:hover { background: #e0e0e0; }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        main { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        footer {
            text-align: center;
            color: white;
            padding: 20px;
            margin-top: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        textarea { resize: vertical; min-height: 100px; }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }
        .card h3 { margin-bottom: 10px; color: #667eea; }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <a href="<?php echo APP_URL; ?>" class="logo">🐠 <?php echo APP_NAME; ?></a>
            <nav>
                <?php if (Session::isLogged()): ?>
                    <?php 
                    // Obtener datos del usuario actual para mostrar avatar
                    $currentUserId = Session::getUserId();
                    $db = Database::getInstance()->getConnection();
                    $stmt = $db->prepare("SELECT avatar_path, username FROM users WHERE id = ?");
                    $stmt->execute([$currentUserId]);
                    $currentUser = $stmt->fetch();
                    ?>
                    <a href="<?php echo APP_URL; ?>/fish">Wiki de Peces</a>
                    <a href="<?php echo APP_URL; ?>/aquarium">Mis Acuarios</a>
                    <a href="<?php echo APP_URL; ?>/fish/create" class="btn btn-secondary" style="padding: 8px 15px; font-size: 14px;">+ Crear Ficha</a>
                    <?php if (Session::isAdmin()): ?>
                        <a href="<?php echo APP_URL; ?>/admin" class="btn btn-secondary" style="padding: 8px 15px; font-size: 14px;">Admin</a>
                    <?php endif; ?>
                    <div class="user-menu">
                        <a href="<?php echo APP_URL; ?>/user/profile" style="display: flex; align-items: center; gap: 8px;">
                            <?php if (!empty($currentUser['avatar_path'])): ?>
                                <img src="<?php echo str_replace('public/', APP_URL . '/', $currentUser['avatar_path']); ?>" 
                                     alt="Avatar" class="user-avatar">
                            <?php else: ?>
                                <div class="user-avatar-placeholder">
                                    <?php echo strtoupper(substr($currentUser['username'], 0, 1)); ?>
                                </div>
                            <?php endif; ?>
                            <span style="color: #666;"><?php echo Security::sanitize(Session::get('full_name')); ?></span>
                        </a>
                        <a href="<?php echo APP_URL; ?>/auth/logout" class="btn btn-primary" style="padding: 8px 15px; font-size: 14px;">Salir</a>
                    </div>
                <?php else: ?>
                    <a href="<?php echo APP_URL; ?>/fish">Wiki</a>
                    <a href="<?php echo APP_URL; ?>/auth/login" class="btn btn-primary">Iniciar Sesión</a>
                    <a href="<?php echo APP_URL; ?>/auth/register" class="btn btn-secondary">Registrarse</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="container">
        <?php if (Response::hasFlash('success')): ?>
            <div class="alert alert-success">
                <?php echo Response::getFlash('success'); ?>
            </div>
        <?php endif; ?>

        <?php if (Response::hasFlash('error')): ?>
            <div class="alert alert-error">
                <?php echo Response::getFlash('error'); ?>
            </div>
        <?php endif; ?>

        <main>
            <?php include $contentView ?? null; ?>
        </main>
    </div>

    <footer>
        <p>&copy; 2025 <?php echo APP_NAME; ?> - Comunidad de Acuaristas v<?php echo APP_VERSION; ?></p>
    </footer>
</body>
</html>
