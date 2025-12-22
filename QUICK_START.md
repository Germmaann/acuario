# ⚡ Quick Start - Guía de 5 Minutos

## Instalación Ultra Rápida

### Paso 1: Crear Base de Datos (2 min)

En cPanel:
1. **Bases de Datos MySQL** → Nueva BD
2. Nombre: `acuario_db`
3. Usuario: `acuario_user`
4. Contraseña: `[genera segura]`
5. ✅ Crear

### Paso 2: Importar SQL (1 min)

En phpMyAdmin:
1. Selecciona `acuario_db`
2. Pestaña **Importar**
3. Elige `database.sql`
4. **Continuar** ✅

### Paso 3: Configurar (1 min)

Editar `app/config/config.php`:
```php
define('DB_USER', 'acuario_user');         // Tu usuario
define('DB_PASS', 'tu_contraseña_aquí');   // Tu contraseña
define('DB_NAME', 'acuario_db');
define('APP_URL', 'https://tudominio.com/acuario');
```

### Paso 4: Permisos (1 min)

Vía Administrador de archivos (o SSH):
```bash
chmod 755 public/uploads
```

## ✅ ¡Listo!

Abre: `https://tudominio.com/acuario`

**Login inicial:**
- Usuario: `admin`
- Contraseña: `admin123`

⚠️ Cambia la contraseña inmediatamente

---

## 🗂️ Estructura Básica

```
acuario/
├── public/              # Carpeta pública
│   ├── index.php        # Punto de entrada
│   ├── .htaccess        # Rewriting
│   └── uploads/         # Imágenes
├── app/
│   ├── config/          # Configuración
│   ├── models/          # Datos
│   ├── controllers/     # Lógica
│   ├── views/           # HTML
│   └── lib/             # Funciones
└── database.sql         # BD
```

---

## 🎯 Primeros Pasos Después de Instalar

1. **Cambiar contraseña admin**
   - Login como admin
   - Ir a perfil
   - Cambiar contraseña

2. **Crear usuario de prueba**
   - Registrarse como nuevo usuario
   - Crear ficha de pez
   - Crear acuario

3. **Moderar como admin**
   - Login como admin
   - Panel → Moderar Fichas
   - Aprobar la ficha

4. **Explorar funciones**
   - Wiki de Peces
   - Crear Acuarios
   - Sistema de Reportes

---

## 🔑 Rutas Principales

| Ruta | Función |
|------|---------|
| `/fish` | Wiki de peces |
| `/aquarium` | Mis acuarios |
| `/auth/login` | Iniciar sesión |
| `/auth/register` | Registrarse |
| `/admin` | Panel admin |

---

## ⚙️ Configuraciones Importantes

### En `app/config/config.php`

```php
// URLs amigables
APP_URL = 'http://localhost/acuario'

// BD
DB_HOST = 'localhost'
DB_USER = 'tu_usuario'
DB_PASS = 'tu_contraseña'
DB_NAME = 'acuario_db'

// Seguridad
SESSION_LIFETIME = 3600 * 24  // 24 horas
MAX_UPLOAD_SIZE = 5242880     // 5MB
```

---

## 📱 Funcionalidades Principales

### Para Usuarios Normales
- ✅ Registrarse
- ✅ Crear fichas de peces
- ✅ Ver wiki colaborativa
- ✅ Crear acuarios personales
- ✅ Reportar errores

### Para Administradores
- ✅ Moderar fichas
- ✅ Gestionar reportes
- ✅ Gestionar usuarios
- ✅ Ver estadísticas

---

## 🐛 Troubleshooting Rápido

**Error: "No conecta a BD"**
```
→ Verificar credenciales en config.php
→ Comprobar que BD existe
```

**Error: "Página no encontrada"**
```
→ Verificar que .htaccess existe
→ Comprobar mod_rewrite habilitado
→ Revisar APP_URL en config.php
```

**Error: "No puedo subir imágenes"**
```
→ Verificar permisos carpeta uploads (755)
→ Comprobar tamaño máximo (5MB)
```

---

## 🔒 Seguridad Básica

Lo que ya está implementado:
- ✅ Contraseñas hashadas (bcrypt)
- ✅ CSRF protection
- ✅ PDO prepared statements
- ✅ Validación de datos
- ✅ Control de permisos
- ✅ Logs de seguridad

**Recomendado para producción:**
- Usar HTTPS
- Hacer backups regulares
- Monitorear logs
- Actualizar PHP
- Usar WAF

---

## 📚 Documentación Completa

Para más información, ver:
- **README.md** - Descripción general
- **INSTALACION_CPANEL.md** - Instalación detallada
- **DEVELOPMENT.md** - Desarrollo
- **API_DOCS.md** - Endpoints
- **TESTING.md** - Pruebas

---

## 💾 Backups

### Hacer backup de BD
```bash
mysqldump -u usuario -p base_datos > backup.sql
```

### Restaurar backup
```bash
mysql -u usuario -p base_datos < backup.sql
```

---

## 🚀 Ir a Producción

Checklist:
- [ ] Cambiar contraseña admin
- [ ] Activar HTTPS
- [ ] Configurar backups automáticos
- [ ] Revisar logs
- [ ] Monitorear performance
- [ ] Actualizar documentación

---

## 📞 Ayuda Rápida

**¿Cómo cambio la contraseña de un usuario?**
- Login como admin → Panel → Usuarios

**¿Cómo apruebo una ficha de pez?**
- Login como admin → Moderación → Aprobar

**¿Cómo veo los reportes?**
- Login como admin → Reportes → Filtrar por estado

**¿Cómo creo un acuario?**
- Login → Mis Acuarios → + Nuevo

---

## ✨ Próximos Pasos Opcionales

- Agregar más peces a la wiki
- Personalizar diseño
- Implementar sistema de ratings (ver FEATURES_FUTUROS.md)
- Agregar más funcionalidades
- Conectar redes sociales

---

**¡Sistema listo para usar!** 🎉

Para preguntas más específicas, consulta la documentación completa en los archivos Markdown.

---

*Última actualización: 20 de Diciembre de 2025*
