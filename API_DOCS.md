# Documentación de la API

## Base URL
```
http://localhost/acuario
```

## Autenticación

Todos los endpoints requieren sesión activa (excepto login y register).

### Verificación
Se valida mediante cookies de sesión y tokens CSRF.

---

## Endpoints

### 1. AUTENTICACIÓN

#### Login
```http
POST /auth/login
Content-Type: application/x-www-form-urlencoded

email=usuario@ejemplo.com&password=contraseña&csrf_token=token
```

**Respuesta exitosa:**
- Redirección a `/dashboard`
- Sesión iniciada

**Errores:**
- `400` - Email o contraseña inválidos
- `403` - Token CSRF inválido

---

#### Registro
```http
POST /auth/register
Content-Type: application/x-www-form-urlencoded

username=nuevo_user&email=email@ejemplo.com&password=pass123&password_confirm=pass123&full_name=Nombre&csrf_token=token
```

**Validaciones:**
- Username: 3+ caracteres, solo alfanuméricos
- Email: Válido y único
- Contraseña: 6+ caracteres
- Las contraseñas deben coincidir

**Respuesta:** Redirección a login

---

#### Logout
```http
GET /auth/logout
```

**Respuesta:** Sesión destruida, redirección a login

---

### 2. WIKI DE PECES

#### Listar peces aprobados
```http
GET /fish?page=1&search=termo&difficulty=medio
```

**Parámetros:**
- `page` - Número de página (default: 1)
- `search` - Búsqueda por nombre (opcional)
- `difficulty` - muy_fácil | fácil | medio | difícil | muy_difícil (opcional)

**Respuesta:** HTML con listado paginado

---

#### Ver detalle de pez
```http
GET /fish/show?id=1
```

**Parámetros:**
- `id` - ID del pez (requerido)

**Respuesta:** HTML con detalles completos

---

#### Crear ficha de pez
```http
POST /fish/create
Content-Type: multipart/form-data

common_name=Pez Rojo&scientific_name=Carassius auratus&...&main_image=file
```

**Campos:**
- `common_name` - Requerido
- `scientific_name` - Opcional
- `family` - Opcional
- `origin` - Opcional
- `size_min`, `size_max` - Tamaño en cm
- `temperature_min`, `temperature_max` - En °C
- `ph_min`, `ph_max` - Valor de pH
- `hardness_min`, `hardness_max` - En dGH
- `behavior`, `compatibility`, `feeding` - Textos
- `difficulty` - muy_fácil | fácil | medio | difícil | muy_difícil
- `lifespan` - Años
- `description` - Descripción larga
- `main_image` - Archivo de imagen

**Respuesta JSON:**
```json
{
  "success": true,
  "message": "Ficha creada. Pendiente de aprobación.",
  "fish_id": 5
}
```

---

#### Reportar error en pez
```http
POST /fish/report
Content-Type: application/x-www-form-urlencoded

fish_id=1&report_type=datos_incorrectos&comment=Comentario&csrf_token=token
```

**Tipos de reporte:**
- `datos_incorrectos` - Información incorrecta
- `compatibilidad` - Error en compatibilidad
- `imagen` - Problemas con imagen
- `otro` - Otro tipo

**Respuesta JSON:**
```json
{
  "success": true,
  "message": "Reporte enviado. Gracias!"
}
```

---

### 3. ACUARIOS

#### Listar acuarios del usuario
```http
GET /aquarium
```

**Respuesta:** HTML con listado de acuarios

---

#### Ver acuario
```http
GET /aquarium/show?id=1
```

**Respuesta:** HTML con detalles del acuario y contenido

---

#### Crear acuario
```http
POST /aquarium/create
Content-Type: application/x-www-form-urlencoded

name=Mi Acuario&description=...&volume_liters=50&...&csrf_token=token
```

**Campos:**
- `name` - Requerido
- `description` - Opcional
- `volume_liters` - Volumen en litros
- `type` - agua_dulce | agua_salada | brackish
- `dimensions_length`, `dimensions_width`, `dimensions_height` - Dimensiones en cm
- `filter_type` - Tipo de filtro
- `lighting_hours` - Horas de luz
- `co2_injection` - Checkbox booleano

**Respuesta JSON:**
```json
{
  "success": true,
  "message": "Acuario creado!",
  "aquarium_id": 3
}
```

---

#### Agregar pez a acuario
```http
POST /aquarium/add-fish
Content-Type: application/x-www-form-urlencoded

aquarium_id=1&fish_id=5&quantity=2&csrf_token=token
```

**Parámetros:**
- `aquarium_id` - ID del acuario
- `fish_id` - ID del pez (debe estar aprobado)
- `quantity` - Cantidad (default: 1)

---

#### Agregar planta
```http
POST /aquarium/add-plant
Content-Type: application/x-www-form-urlencoded

aquarium_id=1&name=Espada Amazon&quantity=3&care_level=fácil&csrf_token=token
```

---

#### Registrar mantenimiento
```http
POST /aquarium/log-maintenance
Content-Type: application/x-www-form-urlencoded

aquarium_id=1&log_type=cambio_agua&percentage=30&csrf_token=token
```

**Tipos:**
- `cambio_agua`
- `limpieza_filtro`
- `fertilizante`
- `medicamento`
- `otro`

---

### 4. ADMINISTRACIÓN

#### Dashboard
```http
GET /admin
```

**Respuesta:** HTML con estadísticas y enlaces rápidos

---

#### Moderar fichas
```http
GET /admin/fish?page=1
```

**Respuesta:** HTML con fichas pendientes

---

#### Actualizar estado de ficha
```http
POST /admin/fish/status
Content-Type: application/x-www-form-urlencoded

fish_id=1&status=aprobado&reason=motivo&csrf_token=token
```

**Estados:**
- `aprobado`
- `rechazado`
- `pendiente`

---

#### Ver reportes
```http
GET /admin/reports?page=1&status=nuevo
```

**Parámetros:**
- `page` - Número de página
- `status` - nuevo | en_revisión | resuelto (opcional)

---

#### Actualizar reporte
```http
POST /admin/reports/status
Content-Type: application/x-www-form-urlencoded

report_id=1&status=resuelto&response=Comentario&csrf_token=token
```

---

#### Listar usuarios
```http
GET /admin/users?page=1
```

---

#### Desactivar usuario
```http
POST /admin/users/deactivate
Content-Type: application/x-www-form-urlencoded

user_id=5&csrf_token=token
```

---

## Códigos de Error

| Código | Significado |
|--------|-------------|
| `200` | OK - Solicitud exitosa |
| `400` | Bad Request - Datos inválidos |
| `401` | Unauthorized - No autenticado |
| `403` | Forbidden - Permisos insuficientes |
| `404` | Not Found - Recurso no existe |
| `405` | Method Not Allowed - Método HTTP no permitido |
| `500` | Internal Server Error - Error del servidor |

---

## Códigos de Respuesta JSON

### Éxito
```json
{
  "success": true,
  "message": "Mensaje descriptivo",
  "data": {}
}
```

### Error
```json
{
  "success": false,
  "message": "Descripción del error"
}
```

---

## Ejemplos con cURL

### Login
```bash
curl -X POST http://localhost/acuario/auth/login \
  -d "email=admin@acuario.local&password=admin123&csrf_token=token"
```

### Crear ficha
```bash
curl -X POST http://localhost/acuario/fish/create \
  -F "common_name=Pez Rojo" \
  -F "scientific_name=Carassius auratus" \
  -F "difficulty=fácil" \
  -F "main_image=@pez.jpg" \
  -F "csrf_token=token"
```

---

**Última actualización:** 2025-12-20
