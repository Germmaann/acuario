# ✨ Nuevas Características - Módulo de Terrarios Avanzado

## 📊 Dashboard con Estadísticas
**Ruta:** `/terrarium/dashboard`

Muestra un panel completo con:
- Total de terrarios (activos, inactivos, en construcción)
- Capacidad total en litros
- Temperatura y humedad promedio
- Alertas de mantenimiento próximo/vencido
- Últimos mantenimientos realizados
- Acciones rápidas

## 🔍 Búsqueda y Filtrado Avanzado
**Ruta:** `/terrarium/search`

Permite buscar terrarios por:
- Nombre (búsqueda por texto)
- Tipo (tropical, desértico, subtropical, húmedo, seco)
- Estado (activo, inactivo, en construcción)
- Combinación de filtros

## 🔔 Alertas de Mantenimiento
En el Dashboard se muestran alertas de:
- Mantenimientos vencidos (en rojo)
- Mantenimientos próximos (en naranja)
- Contador de días hasta vencer
- Link directo al terrario para realizar el mantenimiento

Requisitos:
- Habilitar recordatorio en el mantenimiento
- Establecer días entre recordatorios

## 📸 Mejoras en Galería
**Características:**
- Subida de fotos por terrario
- Establecer imagen como portada
- Títulos y descripciones para fotos
- Vista de galería pública de todos los usuarios

**Galería Pública:**
**Ruta:** `/terrarium/gallery`

- Ver fotos de todos los usuarios
- Mostrar nombre del usuario que subió la foto
- Nombre del terrario
- Fecha de subida
- Paginación de 12 fotos por página

## 👥 Sección de Uploads de Usuarios
Los usuarios pueden ver:
- Todas las fotos compartidas por la comunidad
- Quién las subió (nombre de usuario)
- A qué terrario pertenecen
- Cuando se subieron

## 📄 Exportar/Reportes (En Desarrollo)
**Ruta:** `/terrarium/export-pdf?id=X`

Funcionalidades planeadas:
- Descargar ficha completa del terrario en PDF
- Incluir fotos, parámetros, habitantes, historial
- Reportes de mantenimiento
- Estadísticas del periodo

## 🔌 API/Integraciones (En Desarrollo)
Endpoints API planeados:
- GET `/api/terrarium/stats` - Estadísticas del usuario
- GET `/api/terrarium/alerts` - Alertas pendientes
- POST `/api/terrarium/sync-sensor` - Sincronizar datos de sensores IoT
- GET `/api/gallery/public` - Fotos públicas

## 📱 Menú Actualizado
El menú "Mis Terrarios" ahora tiene un dropdown con acceso rápido a:
- Ver Todos (lista principal)
- Dashboard
- Buscar
- Galería Pública
- Crear Nuevo

## 🗄️ Nuevos Métodos en Modelo
```php
getStatistics($userId)          // Estadísticas generales
search($userId, $term, $type)   // Búsqueda y filtrado
getAllGalleries($limit, $offset) // Galería pública
getRecentMaintenance($userId)   // Últimos mantenimientos
getMaintenanceAlerts($userId)   // Alertas activas
```

## 🛣️ Nuevas Rutas
```
GET  /terrarium/dashboard      - Dashboard con estadísticas
GET  /terrarium/search         - Búsqueda y filtrado
GET  /terrarium/gallery        - Galería pública
GET  /terrarium/export-pdf     - Exportar a PDF
```

## 🎨 Diseño
- Mantiene consistencia con tema Aventro
- Colores por sección:
  - Dashboard: Naranja (#e67e22)
  - Búsqueda: Naranja (#e67e22)
  - Galería: Azul (#3498db)
  - Alertas: Amarillo (#f39c12)
- Animaciones AOS en todas las secciones
- Responsive en mobile, tablet y desktop

## 🚀 Próximas Mejoras
- PDF con librería TCPDF
- Gráficos de temperatura/humedad
- Notificaciones por email
- Integración con sensores IoT
- Compartir terrarios con otros usuarios
- Sistema de comentarios en fotos
