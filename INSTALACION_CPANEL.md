# Guía Rápida de Instalación en cPanel

## 1. Preparación

### Crear base de datos en cPanel
1. Inicia sesión en tu cuenta de cPanel
2. Ve a **Bases de datos MySQL**
3. En "Nueva Base de Datos", crea:
   - Nombre de BD: `tusuario_acuario`
   - Nombre de usuario: `tusuario_acuario_user`
   - Contraseña: (genera una segura)
4. Asigna todos los privilegios al usuario

### Subir archivos
1. Ve a **Administrador de archivos**
2. Entra a la carpeta `public_html`
3. Crea carpeta `acuario`
4. Sube todos los archivos del proyecto

## 2. Importar Base de Datos

### Opción A: phpMyAdmin
1. Ve a **phpMyAdmin** en cPanel
2. Haz clic en tu base de datos `tusuario_acuario`
3. En la barra de pestañas, elige **Importar**
4. Selecciona el archivo `database.sql`
5. Haz clic en **Continuar**

### Opción B: Línea de comandos (SSH)
```bash
# Conectar por SSH
mysql -h localhost -u tusuario_acuario_user -p tusuario_acuario < database.sql
# Ingresa tu contraseña cuando lo pida
```

## 3. Configurar el Sistema

### Editar config.php
1. Ve al **Administrador de archivos**
2. Navega a `acuario/app/config/`
3. Edita `config.php`
4. Busca estas líneas:
   ```php
   define('DB_USER', 'root');      // Cambiar por: tusuario_acuario_user
   define('DB_PASS', '');           // Cambiar por: tu contraseña
   define('DB_NAME', 'acuario_db'); // Cambiar por: tusuario_acuario
   define('APP_URL', 'http://localhost/acuario'); // Cambiar por tu URL
   ```

### Ejemplo:
```php
define('DB_USER', 'miuser_acuario_user');
define('DB_PASS', 'MiContraseña123!');
define('DB_NAME', 'miuser_acuario');
define('APP_URL', 'https://midominio.com/acuario');
```

## 4. Permisos de Carpetas

### Vía cPanel
1. Ve a **Administrador de archivos**
2. Navega a `acuario/public/uploads`
3. Haz clic derecho → **Cambiar permisos**
4. Establece los permisos en **755**

### Vía SSH
```bash
cd public_html/acuario
chmod 755 public/uploads
chmod 755 public/uploads/fish
chmod 755 public/uploads/gallery
chmod 644 public/.htaccess
```

## 5. Verificar .htaccess

El archivo `public/.htaccess` es **IMPORTANTE**. Debe estar presente para que funcionen las URLs amigables.

Contenido esperado:
```apache
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /acuario/
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^(.*)$ - [L]
RewriteCond %{REQUEST_FILENAME} -f
RewriteRule ^(.*)$ - [L]
RewriteRule ^(.*)$ index.php [L,QSA]
</IfModule>
```

## 6. Pruebas Iniciales

### Acceder al sistema
1. Abre tu navegador
2. Vai a: `https://tudominio.com/acuario`
3. Deberías ver la página principal

### Datos de acceso admin
- Usuario: `admin`
- Contraseña: `admin123`

⚠️ **Importante:** Cambia esta contraseña inmediatamente después de acceder

### Probar funcionalidades
- [ ] Login funciona
- [ ] Puedo registrarme
- [ ] Ver wiki de peces funciona
- [ ] Puedo crear una ficha de pez
- [ ] Panel admin accesible
- [ ] Moderar fichas funciona

## 7. Después de la Instalación

### Cambiar contraseña de admin
1. Inicia sesión como admin
2. Ve a tu perfil
3. Cambia la contraseña

### Crear usuario admin adicional
1. Registra un nuevo usuario normal
2. Ve a **Panel Admin** → **Usuarios**
3. Cambia el rol a "admin"

### Configuraciones recomendadas
1. Cambiar `APP_URL` si usas SSL (https)
2. Crear tabla de logs para auditoría
3. Configurar backups automáticos
4. Revisar y actualizar configuración de email (si implementas envío de correos)

## 8. Solución de Problemas

### "Conectado pero sin base de datos"
- Verifica que el nombre de la BD sea correcto
- Verifica usuario y contraseña
- Asegúrate de haber importado SQL

### "Páginas no encontradas / 404"
- Verifica que `public/.htaccess` existe
- Ve a **Configuración Apache** en cPanel y confirma que mod_rewrite esté habilitado
- Prueba cambiar `APP_URL` en config.php

### "No puedo subir imágenes"
- Verifica permisos de carpetas (755)
- Verifica límite de subida en `php.ini` (al menos 5MB)
- Verifica que la carpeta `uploads` existe

### "Error de conexión a base de datos"
- Verifica que MySQL está funcionando
- Comprueba credenciales en config.php
- Verifica que la BD existe

## 📞 Contacto

Si tienes problemas, revisa:
1. Logs de PHP: cPanel → Errores de PHP
2. Logs de MySQL: Administrador de bases de datos
3. Archivo `logs/security.log` en tu aplicación

---
**Última actualización:** 2025-12-20
