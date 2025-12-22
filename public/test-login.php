<?php
session_start();
require_once '../app/config/config.php';
require_once '../app/lib/Database.php';
require_once '../app/lib/Session.php';
require_once '../app/lib/Security.php';

// Generate CSRF token
if (!Session::get('csrf_token')) {
    Session::set('csrf_token', bin2hex(random_bytes(32)));
}
$csrfToken = Session::get('csrf_token');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Login</title>
</head>
<body>
    <h1>Test Form Login</h1>
    
    <form method="POST" action="<?php echo APP_URL; ?>/auth/login">
        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
        
        <label>Email:</label>
        <input type="email" name="email" value="admin@acuario.local" required>
        <br>
        
        <label>Password:</label>
        <input type="password" name="password" value="123456" required>
        <br>
        
        <button type="submit">Login</button>
    </form>
    
    <p>CSRF Token: <?php echo $csrfToken; ?></p>
    <p>Session ID: <?php echo session_id(); ?></p>
</body>
</html>
