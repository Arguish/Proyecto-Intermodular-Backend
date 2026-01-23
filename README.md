# Proyecto-Intermodular-Backend

<!-- TOC tocDepth:2..3 chapterDepth:2..6 -->

- [🛠️ Stack Tecnológico](#🛠️-stack-tecnológico)
- [📋 Requisitos Cubiertos](#📋-requisitos-cubiertos)
- [🗄️ Base de Datos (Relacional)](#🗄️-base-de-datos-relacional)
    - [Diseño del Esquema](#diseño-del-esquema)
- [📝 Backlog de Tareas - Backend](#📝-backlog-de-tareas---backend)
    - [🏗️ Estructura y Base de Datos](#🏗️-estructura-y-base-de-datos)
    - [⚙️ Lógica de Negocio (API)](#⚙️-lógica-de-negocio-api)
    - [🔐 Seguridad y Roles](#🔐-seguridad-y-roles)

<!-- /TOC -->

<!-- TOC tocDepth:2..3 chapterDepth:2..6 -->

- [🛠️ Stack Tecnológico](#🛠️-stack-tecnológico)
- [📋 Requisitos Cubiertos](#📋-requisitos-cubiertos)
- [🗄️ Base de Datos (Relacional)](#🗄️-base-de-datos-relacional)
    - [Diseño del Esquema](#diseño-del-esquema)
- [📝 Backlog de Tareas - Backend](#📝-backlog-de-tareas---backend)
    - [🏗️ Estructura y Base de Datos](#🏗️-estructura-y-base-de-datos)
    - [⚙️ Lógica de Negocio (API)](#⚙️-lógica-de-negocio-api)
    - [🔐 Seguridad y Roles](#🔐-seguridad-y-roles)

<!-- /TOC -->

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

## 📝 Backlog de Tareas - Backend

### 🏗️ Estructura y Base de Datos

- [ ] Configurar el proyecto inicial Laravel 11 Vanilla y entorno `.env`.
- [ ] Diseñar y ejecutar migraciones para MariaDB (`users`, `materials`, `rooms`, `loans`, `reservations`).
- [ ] Implementar modelos Eloquent con sus respectivas relaciones (1:N, N:M).
- [ ] Configurar el sistema de autenticación y protección de rutas API.

### ⚙️ Lógica de Negocio (API)

- [ ] Crear el CRUD completo para la gestión de materiales y aulas (Backoffice).
- [ ] Desarrollar el servicio web para el listado de recursos y su esIPyt### - [ ] Asegurar que el registro de usuarios capture los datos básicos y departamento.
      r the [MIT license](https://opensource.org/licenses/MIT).
      nciar accesos entre Admin y Profesorado.
      tarponibilidad.
- [ ] Programar la lógica de validación de fechas para evitar solapamientos en reservas.
- [ ] IPyt### - [ ] Asegurar que el registro de usuarios capture los datos básicos y departamento.
      r the [MIT license](https://opensource.org/licenses/MIT).
      nciar accesos entre Admin y Profesorado.
      tar el sistema de gestión de excepciones para controlar errores de reserva (basado en lógica Pyt### - [ ] Asegurar que el registro de usuarios capture los datos básicos y departamento.
      r the [MIT license](https://opensource.org/licenses/MIT).
      nciar accesos entre Admin y Profesorado.
      .105, 298].
- [ ] Crear endpoint de "Alertas" que identifique registros con estado 'atrasado'.

### - [ ] Asegurar que el registro de usuarios capture los datos básicos y departamento.

r the [MIT license](https://opensource.org/licenses/MIT).
nciar accesos entre Admin y Profesorado.
🔐 Seguridad y Roles

- [ ] Implementar middleware para diferenciar accesos entre Admin y Profesorado.
- [ ] Asegurar que el registro de usuarios capture los datos básicos y departamento.
      r the [MIT license](https://opensource.org/licenses/MIT).
      nciar accesos entre Admin y Profesorado.
- [ ] Asegurar que el registro de usuarios capture los datos básicos y departamento.
