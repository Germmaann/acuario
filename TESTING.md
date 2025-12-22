# Guía de Pruebas

Checklist para probar todas las funcionalidades del sistema.

## 🔐 Autenticación

- [ ] **Login** - Acceder con admin/admin123
  - [ ] Email/contraseña incorrectos muestran error
  - [ ] Login exitoso redirige a dashboard
  - [ ] Sesión persiste al navegar

- [ ] **Registro** - Crear nuevo usuario
  - [ ] Username con caracteres inválidos rechazado
  - [ ] Email duplicado rechazado
  - [ ] Contraseñas no coincidentes rechazado
  - [ ] Registro exitoso permite login

- [ ] **Logout** - Cerrar sesión
  - [ ] Sesión destruida
  - [ ] Redirige a login
  - [ ] Área protegida no accesible

- [ ] **Recuperar Contraseña**
  - [ ] Email válido acepta solicitud
  - [ ] Email no existente no revela información
  - [ ] Token generado y almacenado

## 📚 Wiki de Peces

- [ ] **Listar Peces**
  - [ ] Mostrar solo peces aprobados
  - [ ] Mostrar de forma paginada
  - [ ] Búsqueda funciona
  - [ ] Filtro de dificultad funciona

- [ ] **Ver Detalle de Pez**
  - [ ] Información completa visible
  - [ ] Imágenes cargan correctamente
  - [ ] Datos del autor visible
  - [ ] No logueados no ven botón reportar

- [ ] **Crear Ficha de Pez**
  - [ ] Solo usuarios logueados pueden crear
  - [ ] Campos requeridos validados
  - [ ] Imagen se carga correctamente
  - [ ] Ficha queda en estado "pendiente"
  - [ ] Usuario ve su ficha creada

- [ ] **Reportar Error**
  - [ ] Solo usuarios logueados pueden reportar
  - [ ] Tipo de reporte requerido
  - [ ] Comentario requerido
  - [ ] No permite reportar dos veces el mismo pez
  - [ ] Reporte se guarda correctamente

## 🐠 Módulo de Acuarios

- [ ] **Crear Acuario**
  - [ ] Solo usuarios logueados
  - [ ] Nombre requerido
  - [ ] Datos se guardan correctamente
  - [ ] Redirige a vista del acuario

- [ ] **Ver Acuario**
  - [ ] Información del acuario visible
  - [ ] Mostrar peces agregados
  - [ ] Mostrar plantas
  - [ ] Mostrar bitácora de mantenimiento

- [ ] **Agregar Pez**
  - [ ] Solo acepta peces aprobados
  - [ ] Cantidad configurable
  - [ ] Se agrega a la lista

- [ ] **Agregar Planta**
  - [ ] Nombre requerido
  - [ ] Se muestra en lista

- [ ] **Bitácora de Mantenimiento**
  - [ ] Registrar cambio de agua
  - [ ] Registrar limpieza de filtro
  - [ ] Registrar fertilizante
  - [ ] Historial visible

## 🔧 Panel Administrativo

- [ ] **Dashboard**
  - [ ] Solo admins pueden acceder
  - [ ] Mostrar estadísticas
  - [ ] Enlace rápido a moderación

- [ ] **Moderar Fichas**
  - [ ] Mostrar fichas pendientes
  - [ ] Botón para aprobar
  - [ ] Botón para rechazar con motivo
  - [ ] Pez aprobado visible en wiki

- [ ] **Gestionar Reportes**
  - [ ] Mostrar todos los reportes
  - [ ] Filtro por estado funciona
  - [ ] Actualizar estado del reporte
  - [ ] Agregar comentario de admin

- [ ] **Gestionar Usuarios**
  - [ ] Mostrar listado de usuarios
  - [ ] Botón para desactivar usuario
  - [ ] No permitir desactivar admin propio
  - [ ] Usuario desactivado no puede login

## 🔒 Seguridad

- [ ] **CSRF Protection**
  - [ ] Tokens en formularios
  - [ ] Token inválido rechazado

- [ ] **Validación de Datos**
  - [ ] Datos malformados rechazados
  - [ ] XSS no es posible

- [ ] **Subida de Archivos**
  - [ ] Formato inválido rechazado
  - [ ] Archivo muy grande rechazado
  - [ ] Nombre de archivo sanitizado

- [ ] **Permisos**
  - [ ] Usuario no puede editar peces de otros
  - [ ] No logueados no pueden acceder a área privada
  - [ ] No admin no puede acceder panel admin

## 🎨 UI/UX

- [ ] **Navegación**
  - [ ] Menú principal funciona
  - [ ] Enlaces funcionan
  - [ ] Redirecciones correctas

- [ ] **Formularios**
  - [ ] Validation messages claros
  - [ ] Errores mostrados apropiadamente
  - [ ] Éxitos confirmados

- [ ] **Responsivo**
  - [ ] Funciona en mobile
  - [ ] Funciona en tablet
  - [ ] Funciona en desktop

- [ ] **Performance**
  - [ ] Página carga rápido
  - [ ] Búsqueda es rápida
  - [ ] No hay errores en consola

## 🐛 Bugs Comunes a Verificar

- [ ] No hay errores PHP en logs
- [ ] No hay errores JavaScript en consola
- [ ] Base de datos conecta correctamente
- [ ] Carpetas de upload tienen permisos
- [ ] .htaccess funciona
- [ ] URLs amigables funcionan
- [ ] Sesiones persisten
- [ ] Cookies funcionan

## 📋 Script de Prueba Manual

### Crear escenario de prueba completo

1. **Limpiar datos previos**
   ```sql
   DELETE FROM fish_wiki;
   DELETE FROM aquariums;
   DELETE FROM users WHERE id > 1;
   ```

2. **Registrar usuario de prueba**
   - Usuario: `testuser`
   - Email: `test@example.com`
   - Contraseña: `test123`

3. **Crear ficha de pez de prueba**
   - Nombre: "Pez Dorado"
   - Científico: "Carassius auratus"
   - Dificultad: Fácil

4. **Moderar como admin**
   - Login con admin
   - Ir a moderar
   - Aprobar ficha

5. **Usuario crea acuario**
   - Login con testuser
   - Crear acuario
   - Agregar pez dorado
   - Registrar mantenimiento

6. **Reportar error**
   - Ver pez dorado
   - Reportar error ficticio

7. **Admin revisa reporte**
   - Login con admin
   - Ver reportes
   - Resolver reporte

## ✅ Criterios de Aceptación

Todas las siguientes deben ser verdaderas:

- [ ] Sistema despliega sin errores
- [ ] Todos los CRUD funcionan
- [ ] Seguridad implementada correctamente
- [ ] UI es intuitiva
- [ ] Performance es aceptable
- [ ] No hay datos expuestos
- [ ] Logs registran eventos
- [ ] Documentación es clara

## 🚀 Deployment Checklist

Antes de ir a producción:

- [ ] Cambiar credenciales de admin
- [ ] Configurar HTTPS
- [ ] Validar backups
- [ ] Revisar logs
- [ ] Establecer limite de rate
- [ ] Monitoreo activo
- [ ] Plan de recuperación
- [ ] Documentación actualizada

---

**Última actualización:** 2025-12-20
