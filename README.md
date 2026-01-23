# Proyecto-Intermodular-Backend

# IES El Rincón - Backend (Gestión de Recursos)

Este es el núcleo de la aplicación, encargado de la persistencia de datos y la lógica de negocio de préstamos y reservas.

## 🛠️ Stack Tecnológico

- **Framework:** Laravel 10/11 (Vanilla).
- **Base de Datos:** MariaDB/MySQL.

## 📋 Requisitos Cubiertos

- **Autenticación:** Sistema de login para Profesores y Administradores.
- **Perfiles:** Diferenciación de permisos mediante roles (Admin/Profesor).
- **Backoffice:** Panel administrativo con CRUD para la gestión de materiales y aulas.
- **API REST:** Implementación de servicios web para comunicación con el Frontend.

## 🗄️ Base de Datos (Relacional)

El esquema incluye las tablas `users`, `materials`, `rooms`, `material_loans` y `room_reservations`. Se utiliza MariaDB para garantizar la integridad referencial.

### Diseño del Esquema

#### Tabla de Usuarios (Profesores y Admins)

```sql
users
  - id (PK)
  - name
  - email (unique) // Credenciales de acceso
  - password
  - department
  - role // 'admin' o 'profesor'
  - created_at
```

#### Tabla de Aulas

```sql
rooms
  - id (PK)
  - name
  - barcode (unique) // Identificador único por código de barras
  - description
```

#### Tabla de Material (Portátiles, proyectores, etc.)

```sql
materials
  - id (PK)
  - name
  - barcode (unique) // Identificador único por código de barras
  - status (default: 'disponible') // disponible, averiado, etc.
```

#### Gestión de Reservas de Aulas

```sql
room_reservations
  - id (PK)
  - user_id (FK -> users.id)
  - room_id (FK -> rooms.id)
  - start_date
  - end_date
  - observations
  - status // 'activa', 'finalizada', 'atrasada'
  - created_at
```

#### Gestión de Préstamos de Material

```sql
material_loans
  - id (PK)
  - user_id (FK -> users.id)
  - material_id (FK -> materials.id)
  - loan_date // Fecha de salida
  - due_date // Fecha prevista de devolución
  - return_date // Fecha real de devolución (null si no se ha devuelto)
  - observations
  - status // 'prestado', 'devuelto', 'atrasado'
```

#### Relaciones

- `room_reservations.user_id` → `users.id`
- `room_reservations.room_id` → `rooms.id`
- `material_loans.user_id` → `users.id`
- `material_loans.material_id` → `materials.id`

**Responsable:** Andrea (Backend Expert) y Javier (Tech Lead)
