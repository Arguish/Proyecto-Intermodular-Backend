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

# IES El Rincón - Backend (Gestión de Recursos)

Este es el núcleo de la aplicación, encargado de la persistencia de datos y la lógica de negocio de préstamos y reservas.

## 🛠️ Stack Tecnológico

- **Framework:** Laravel 12.
- **Base de Datos:** SQLite en local, PostgreSQL recomendado en Render.

## Render y Docker

La configuracion de despliegue mas simple para este proyecto es:

- Un solo servicio web Docker en Render.
- Una base de datos PostgreSQL gestionada por Render.
- Sin Redis, sin workers y sin disco persistente.

Se han añadido estos archivos para dejar el entorno preparado:

- `Dockerfile`: imagen de produccion basada en `php:8.2-apache`.
- `.dockerignore`: reduce el contexto del build.
- `docker/apache-vhost.conf`: Apache sirviendo Laravel desde `public/`.
- `docker/entrypoint.sh`: ajusta el puerto de Render y ejecuta migraciones.
- `render.yaml`: blueprint de Render con el servicio web y PostgreSQL.

### Despliegue en Render

1. Sube este repositorio a GitHub.
2. En Render, crea el servicio usando el archivo `render.yaml` del repositorio.
3. Antes del primer despliegue, genera una clave de Laravel en local con este comando y guarda el valor:

```bash
php artisan key:generate --show
```

4. En Render, rellena al menos estas variables que han quedado como manuales:

```text
APP_URL=https://tu-servicio.onrender.com
APP_KEY=base64:...
FRONTEND_URL=https://tu-frontend.onrender.com
SANCTUM_STATEFUL_DOMAINS=tu-frontend.onrender.com
```

5. Lanza el primer deploy. El contenedor ejecutara `php artisan migrate --force` al arrancar.
6. Comprueba que el health check responde en `/up`.

### Notas de produccion

- La API usa Bearer tokens de Sanctum, asi que no depende de cookies stateful para autenticarse.
- `DB_CONNECTION` queda fijado a `pgsql` en Render porque SQLite no es adecuado para el filesystem efimero.
- No hace falta instalar Node dentro del contenedor porque este backend se despliega como API y la vista de bienvenida ya tiene fallback sin Vite.

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
- [ ] Desarrollar el servicio web para el listado de recursos y su estado de disponibilidad.
- [ ] Programar la lógica de validación de fechas para evitar solapamientos en reservas.
- [ ] Implementar el sistema de gestión de excepciones para controlar errores de reserva (basado en lógica Python).105, 298].
- [ ] Crear endpoint de "Alertas" que identifique registros con estado 'atrasado'.

### 🔐 Seguridad y Roles

- [ ] Implementar middleware para diferenciar accesos entre Admin y Profesorado.
- [ ] Asegurar que el registro de usuarios capture los datos básicos y departamento.
