# 🐠 Sistema Web de Acuarismo

Sistema web completo para gestionar una comunidad colaborativa de acuaristas con wiki de peces, módulo de acuarios personales y panel administrativo.

## 📋 Características

### 1. Sistema de Usuarios
- ✅ Registro e inicio de sesión seguro
- ✅ Recuperación de contraseña
- ✅ Sistema de roles (admin, usuario)
- ✅ Perfiles de usuario

### 2. Wiki Colaborativa de Peces
- ✅ Crear fichas de peces
- ✅ Sistema de aprobación (pendiente/aprobado/rechazado)
- ✅ Galería de imágenes
- ✅ Datos completos (temperatura, pH, dureza, compatibilidad, etc.)
- ✅ Búsqueda y filtrado por dificultad
- ✅ Historial de ediciones
- ✅ **Botón "Reportar Error"** para cada ficha
- ✅ Sistema de reportes con estados

### 3. Módulo de Acuarios del Usuario
- ✅ Crear múltiples acuarios
- ✅ Asociar peces aprobados
- ✅ Registro de plantas y sustratos
- ✅ Bitácora de mantenimiento
- ✅ Galería de imágenes del acuario
- ✅ Línea de tiempo del proyecto

### 4. Panel Administrativo
- ✅ Dashboard con estadísticas
- ✅ Moderación de fichas propuestas
- ✅ Gestión de reportes (filtrable por estado)
- ✅ Gestión de usuarios
- ✅ Logs de seguridad

### 5. Seguridad
- ✅ Hash de contraseñas con bcrypt
- ✅ Protección CSRF en formularios
- ✅ Prepared statements (PDO)
- ✅ Sanitización de inputs
- ✅ Control de permisos basado en roles
- ✅ Subida segura de archivos
- ✅ Logs de eventos de seguridad

## 🚀 Instalación

### Requisitos
- PHP 8.0 o superior
- MySQL 5.7 o superior
- Apache con módulo rewrite habilitado
- cPanel (compatible)

### Pasos de Instalación

#### 1. Descargar archivos
```bash
# Copiar todos los archivos a tu servidor
# Estructura recomendada en cPanel: /public_html/acuario/
```

#### 2. Crear base de datos
```bash
# En cPanel:
# 1. Ir a "Bases de datos MySQL"
# 2. Crear nueva BD: "acuario_db"
# 3. Crear usuario: "acuario_user"
# 4. Asignar todos los permisos
```

#### 3. Importar SQL
```bash
# Opción A: phpMyAdmin
# 1. Abrir phpMyAdmin
# 2. Seleccionar base de datos "acuario_db"
# 3. Ir a "Importar"
# 4. Seleccionar archivo "database.sql"
# 5. Hacer clic en "Continuar"

# Opción B: Línea de comandos (SSH)
mysql -u acuario_user -p acuario_db < database.sql
```

#### 4. Configurar conexión
Editar `app/config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'acuario_user');
define('DB_PASS', 'tu_contraseña');
define('DB_NAME', 'acuario_db');
define('APP_URL', 'http://tudominio.com/acuario');
```

#### 5. Permisos de carpetas
```bash
# En cPanel (Terminal o SSH):
chmod 755 public/uploads
chmod 755 public/uploads/fish
chmod 755 public/uploads/gallery
chmod 755 app/
```

#### 6. Verificar .htaccess
El archivo `public/.htaccess` debe estar presente para el rewriting de URLs.

## 📝 Base de Datos

### Tablas Principales

#### users
- Almacena usuarios con hash de contraseña
- Campos: id, username, email, password_hash, full_name, role_id, is_active

#### fish_wiki
- Fichas de peces colaborativas
- Estados: pendiente, aprobado, rechazado
- Campos: common_name, scientific_name, family, temperatura, pH, dureza, etc.

#### fish_reports
- Reportes de errores en fichas
- Estados: nuevo, en_revisión, resuelto
- Tipos: datos_incorrectos, compatibilidad, imagen, otro

#### aquariums
- Acuarios personales del usuario
- Vinculados a usuario mediante user_id

#### maintenance_logs
- Bitácora de cambios de agua, limpieza, etc.

## 🔐 Credenciales por Defecto

**Usuario Admin:**
- Usuario: `admin`
- Email: `admin@acuario.local`
- Contraseña: `admin123`

⚠️ **IMPORTANTE:** Cambiar la contraseña de admin inmediatamente después de la instalación.

## 📖 Uso

### Como Usuario Normal
1. Registrarse en `/auth/register`
2. Iniciar sesión
3. Crear fichas de peces (serán revisadas por admin)
4. Crear acuarios personales
5. Agregar peces aprobados a sus acuarios
6. Reportar errores en fichas

### Como Administrador
1. Ir a `/admin`
2. Panel con estadísticas
3. Moderar fichas pendientes
4. Gestionar reportes
5. Gestionar usuarios

## 🛠️ Estructura de Carpetas

```
acuario/
├── app/
│   ├── config/          # Configuración
│   ├── controllers/     # Controladores MVC
│   ├── models/          # Modelos de datos
│   ├── lib/             # Clases utilitarias
│   └── views/           # Vistas HTML/PHP
├── public/
│   ├── index.php        # Punto de entrada
│   ├── .htaccess        # Rewriting de URLs
│   ├── assets/          # CSS, JS
│   └── uploads/         # Imágenes subidas
├── database.sql         # Script de base de datos
└── README.md           # Este archivo
```

## 📝 API Endpoints

### Autenticación
- `POST /auth/login` - Iniciar sesión
- `POST /auth/register` - Registrar usuario
- `POST /auth/forgot-password` - Recuperar contraseña
- `GET /auth/logout` - Cerrar sesión

### Wiki de Peces
- `GET /fish` - Listar peces aprobados
- `GET /fish/show?id=X` - Ver detalle de pez
- `POST /fish/create` - Crear nueva ficha
- `POST /fish/report` - Reportar error

### Acuarios
- `GET /aquarium` - Listar acuarios del usuario
- `GET /aquarium/show?id=X` - Ver acuario
- `POST /aquarium/create` - Crear acuario
- `POST /aquarium/add-fish` - Agregar pez
- `POST /aquarium/add-plant` - Agregar planta
- `POST /aquarium/log-maintenance` - Registrar mantenimiento

### Administración
- `GET /admin` - Dashboard
- `GET /admin/fish` - Moderar fichas
- `POST /admin/fish/status` - Aprobar/rechazar ficha
- `GET /admin/reports` - Ver reportes
- `POST /admin/reports/status` - Actualizar reporte
- `GET /admin/users` - Gestionar usuarios
- `POST /admin/users/deactivate` - Desactivar usuario

## 🔒 Seguridad

### Implementado
- ✅ Contraseñas hasheadas con bcrypt
- ✅ CSRF tokens en todos los formularios
- ✅ Prepared statements (PDO)
- ✅ Sanitización de inputs
- ✅ Validación backend y frontend
- ✅ Control de permisos por rol
- ✅ Logs de eventos de seguridad
- ✅ Validación de tipos MIME para archivos
- ✅ Límite de tamaño de subidas
- ✅ Nombres de archivo seguros

### Recomendaciones Adicionales
1. Usar HTTPS en producción
2. Cambiar constantes de sesión
3. Configurar firewall
4. Realizar backups regulares
5. Monitorear logs de seguridad en `logs/security.log`

## 📞 Soporte

Para problemas:
1. Verificar permisos de carpetas
2. Revisar logs de PHP y MySQL
3. Validar credenciales de BD
4. Comprobar versión de PHP
5. Verificar que módulo rewrite esté habilitado

## 📄 Licencia

Sistema desarrollado como ejemplo educativo.

## 🎯 Posibles Mejoras Futuras

- Sistema de notificaciones
- Editor visual para fichas
- Exportar a PDF
- Sistema de ratings
- Integración con redes sociales
- App móvil
- Geolocalización de acuarios
- Sistema de mensajería entre usuarios
- Estadísticas avanzadas

---

**Versión:** 1.0.0  
**Última actualización:** 2025-12-20
