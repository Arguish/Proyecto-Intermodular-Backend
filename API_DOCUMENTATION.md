# API Documentation - IES El Rincón Backend

## 🔗 Base URL

```
http://localhost:8000/api
```

## 🔐 Autenticación

### Login

Obtener token de acceso para usuario existente.

**Endpoint:** `POST /login`

**Body:**

```json
{
    "email": "admin@iesrincon.es",
    "password": "admin123"
}
```

**Response:**

```json
{
    "access_token": "1|xxxxxxxxxxxxxx",
    "token_type": "Bearer",
    "user": {
        "id": 1,
        "name": "Admin Principal",
        "email": "admin@iesrincon.es",
        "department": "Administración",
        "role": "admin"
    }
}
```

### Register

Crear nuevo usuario (solo admins).

**Endpoint:** `POST /register`

**Body:**

```json
{
    "name": "Nuevo Profesor",
    "email": "profesor@iesrincon.es",
    "password": "password123",
    "password_confirmation": "password123",
    "department": "Matemáticas",
    "role": "profesor"
}
```

### Logout

Cerrar sesión del usuario autenticado.

**Endpoint:** `POST /logout`

**Headers:** `Authorization: Bearer {token}`

### Me

Obtener información del usuario autenticado.

**Endpoint:** `GET /me`

**Headers:** `Authorization: Bearer {token}`

---

## 🏫 Aulas (Rooms)

Todas las rutas requieren autenticación.

### Listar todas las aulas

**Endpoint:** `GET /rooms`

**Headers:** `Authorization: Bearer {token}`

### Obtener un aula específica

**Endpoint:** `GET /rooms/{id}`

**Headers:** `Authorization: Bearer {token}`

### Crear nueva aula

**Endpoint:** `POST /rooms`

**Headers:** `Authorization: Bearer {token}`

**Body:**

```json
{
    "name": "Aula 301",
    "barcode": "AULA-301-BC",
    "description": "Aula con proyector y pizarra digital"
}
```

### Actualizar aula

**Endpoint:** `PUT /rooms/{id}`

**Headers:** `Authorization: Bearer {token}`

**Body:**

```json
{
    "name": "Aula 301 - Actualizada",
    "description": "Nueva descripción"
}
```

### Eliminar aula

**Endpoint:** `DELETE /rooms/{id}`

**Headers:** `Authorization: Bearer {token}`

---

## 💻 Materiales (Materials)

### Listar todos los materiales

**Endpoint:** `GET /materials`

**Headers:** `Authorization: Bearer {token}`

### Obtener un material específico

**Endpoint:** `GET /materials/{id}`

**Headers:** `Authorization: Bearer {token}`

### Crear nuevo material

**Endpoint:** `POST /materials`

**Headers:** `Authorization: Bearer {token}`

**Body:**

```json
{
    "name": "Portátil Lenovo ThinkPad",
    "barcode": "LAPTOP-003-BC",
    "status": "disponible"
}
```

**Status values:** `disponible`, `averiado`, `en_mantenimiento`

### Actualizar material

**Endpoint:** `PUT /materials/{id}`

**Headers:** `Authorization: Bearer {token}`

**Body:**

```json
{
    "status": "averiado"
}
```

### Eliminar material

**Endpoint:** `DELETE /materials/{id}`

**Headers:** `Authorization: Bearer {token}`

---

## 📅 Reservas de Aulas (Room Reservations)

### Listar todas las reservas

**Endpoint:** `GET /room-reservations`

**Headers:** `Authorization: Bearer {token}`

### Obtener una reserva específica

**Endpoint:** `GET /room-reservations/{id}`

**Headers:** `Authorization: Bearer {token}`

### Crear nueva reserva

**Endpoint:** `POST /room-reservations`

**Headers:** `Authorization: Bearer {token}`

**Body:**

```json
{
    "user_id": 2,
    "room_id": 1,
    "start_date": "2026-01-25 09:00:00",
    "end_date": "2026-01-25 11:00:00",
    "observations": "Clase de programación",
    "status": "activa"
}
```

**Status values:** `activa`, `finalizada`, `atrasada`

### Actualizar reserva

**Endpoint:** `PUT /room-reservations/{id}`

**Headers:** `Authorization: Bearer {token}`

**Body:**

```json
{
    "status": "finalizada",
    "observations": "Clase finalizada correctamente"
}
```

### Eliminar reserva

**Endpoint:** `DELETE /room-reservations/{id}`

**Headers:** `Authorization: Bearer {token}`

---

## 📦 Préstamos de Material (Material Loans)

### Listar todos los préstamos

**Endpoint:** `GET /material-loans`

**Headers:** `Authorization: Bearer {token}`

### Obtener un préstamo específico

**Endpoint:** `GET /material-loans/{id}`

**Headers:** `Authorization: Bearer {token}`

### Crear nuevo préstamo

**Endpoint:** `POST /material-loans`

**Headers:** `Authorization: Bearer {token}`

**Body:**

```json
{
    "user_id": 3,
    "material_id": 1,
    "loan_date": "2026-01-23 10:00:00",
    "due_date": "2026-01-30 10:00:00",
    "observations": "Portátil para proyecto final",
    "status": "prestado"
}
```

**Status values:** `prestado`, `devuelto`, `atrasado`

### Actualizar préstamo (ej: marcar como devuelto)

**Endpoint:** `PUT /material-loans/{id}`

**Headers:** `Authorization: Bearer {token}`

**Body:**

```json
{
    "return_date": "2026-01-29 14:30:00",
    "status": "devuelto",
    "observations": "Devuelto en buen estado"
}
```

### Eliminar préstamo

**Endpoint:** `DELETE /material-loans/{id}`

**Headers:** `Authorization: Bearer {token}`

---

## 👥 Usuarios de Prueba

### Administrador

- **Email:** admin@iesrincon.es
- **Password:** admin123
- **Role:** admin

### Profesores

- **Email:** andrea@iesrincon.es | **Password:** profesor123 | **Department:** Informática
- **Email:** javier@iesrincon.es | **Password:** profesor123 | **Department:** Informática
- **Email:** maria@iesrincon.es | **Password:** profesor123 | **Department:** Matemáticas

---

## 📝 Notas Importantes

1. **Autenticación:** Todas las rutas excepto `/login` y `/register` requieren el header `Authorization: Bearer {token}`
2. **CORS:** Configurar CORS en `config/cors.php` para permitir peticiones desde el frontend
3. **Validaciones:** Todos los endpoints validan los datos de entrada
4. **Relaciones:** Los endpoints cargan las relaciones necesarias (user, room, material)
5. **Códigos de Estado:**
    - 200: OK
    - 201: Created
    - 401: Unauthorized
    - 404: Not Found
    - 422: Validation Error

---

## 🧪 Testing con Postman/Thunder Client

### 1. Login

```bash
POST http://localhost:8000/api/login
Content-Type: application/json

{
  "email": "admin@iesrincon.es",
  "password": "admin123"
}
```

### 2. Guardar el token recibido

### 3. Usar el token en las siguientes peticiones

```bash
GET http://localhost:8000/api/rooms
Authorization: Bearer 1|xxxxxxxxxxxxxx
```
