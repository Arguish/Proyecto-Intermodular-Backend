# 📋 Plan de Trabajo - Backend API REST

> **Proyecto:** Sistema de Gestión de Reservas  
> **Tecnología:** Laravel 11 + SQLite + Sanctum  
> **Arquitectura:** API REST sin versionado  
> **Estado:** En desarrollo (20% completo)

---

## 🎯 Decisiones Arquitectónicas

### ✅ Confirmadas

1. **Base de Datos:** SQLite
2. **Autenticación:** Laravel Sanctum (Bearer Tokens)
3. **Estructura de Reservas:** Tabla unificada `reservations` con relación **muchos-a-muchos** con `materials`
4. **Validaciones:** Form Requests (clases dedicadas)
5. **Respuestas:** API Resources
6. **Testing:** No se implementará
7. **Versionado API:** Sin versionado (`/api/users`)
8. **Orden:** Bottom-Up (BD → Modelos → Controladores → Rutas)
9. **Middleware:** Preparado pero sin aplicar hasta el final
10. **CORS:** Configurable desde `.env`
11. **Control de Versiones:** Commits granulares por bloque implementado (ver estrategia abajo)

---

## 🔀 Estrategia de Commits

### 📝 Objetivo

Mantener un historial de Git limpio y comprensible que permita a los compañeros seguir fácilmente el progreso del desarrollo.

### ✅ Reglas de Commits

1. **Un commit por bloque lógico completado**
    - ✅ Una migración completa = 1 commit
    - ✅ Un modelo con sus relaciones = 1 commit
    - ✅ Un controlador completo = 1 commit
    - ✅ Configuración relacionada (ej: CORS + Sanctum) = 1 commit

2. **NO hacer commits masivos**
    - ❌ Evitar commits con 20+ archivos de diferentes contextos
    - ❌ No commitear toda una fase de golpe

3. **Formato de mensaje de commit**

    ```
    [FASE X.X] Tipo: Descripción concisa

    - Detalle 1
    - Detalle 2
    ```

### 📋 Ejemplos de Commits por Fase

#### FASE 0: Puesta a Punto

```bash
git commit -m "[FASE 0] Docs: Añadir documentación y plan de trabajo

- GuiaBackend.md: Especificación de la API del frontend
- PlanDeTrabajo.md: Plan completo de desarrollo con estrategia de commits
- Estado verificado: Laravel 12.48.1 + PHP 8.2.12 funcionando
- Preparado para comenzar desarrollo"
```

#### FASE 1: Configuración

```bash
git commit -m "[FASE 1.1] Config: Configurar SQLite y crear BD

- Modificar .env para usar SQLite
- Crear archivo database/database.sqlite
- Actualizar .env.example"

git commit -m "[FASE 1.1] Install: Laravel Sanctum

- composer require laravel/sanctum
- Publicar configuración y migraciones
- Configurar sanctum.php"

git commit -m "[FASE 1.1] Config: CORS y variables de entorno

- Configurar CORS en config/cors.php
- Añadir FRONTEND_URL a .env
- Documentar en .env.example"

git commit -m "[FASE 1.2] Middleware: Preparar RoleMiddleware

- Crear app/Http/Middleware/RoleMiddleware.php
- Registrar en bootstrap/app.php
- Middleware listo pero sin activar"
```

#### FASE 2: Base de Datos

```bash
git commit -m "[FASE 2.1] Migration: Modificar tabla users

- Actualizar enum de roles a ['admin', 'profesor']
- Verificar password y department
- Preparar relación con reservations"

git commit -m "[FASE 2.1] Migration: Modificar tabla materials

- Renombrar name → nombre
- Añadir: codigo, categoria, estado, disponible
- Eliminar campo status obsoleto"

git commit -m "[FASE 2.1] Migration: Crear tabla rooms

- Crear migración create_rooms_table
- Campos: nombre, codigo, tipo, capacidad, ubicacion, disponible, equipamiento"

git commit -m "[FASE 2.1] Migration: Eliminar migraciones obsoletas

- Eliminar create_material_loans_table
- Eliminar create_room_reservations_table
- Preparar para tabla unificada reservations"

git commit -m "[FASE 2.1] Migration: Crear tabla reservations

- Tabla unificada para materiales y aulas
- Campos: user_id, room_id (nullable), fechas, estado, observaciones
- Foreign keys configuradas"

git commit -m "[FASE 2.1] Migration: Crear tabla pivote material_reservation

- Relación muchos-a-muchos materials <-> reservations
- Preparado para futuras extensiones (cantidad, etc.)"

git commit -m "[FASE 2.2] Model: Actualizar User con Sanctum

- Añadir trait HasApiTokens
- Añadir relación hasMany(Reservation)
- Actualizar fillable con department"

git commit -m "[FASE 2.2] Model: Actualizar Material

- Actualizar fillable con nuevos campos
- Añadir cast disponible → boolean
- Añadir relación belongsToMany(Reservation)"

git commit -m "[FASE 2.2] Model: Eliminar modelos obsoletos

- Eliminar MaterialLoan.php
- Eliminar RoomReservation.php"

git commit -m "[FASE 2.2] Model: Crear Room

- Crear modelo Room con fillable
- Cast equipamiento → array y disponible → boolean
- Relación hasMany(Reservation)"

git commit -m "[FASE 2.2] Model: Crear Reservation

- Modelo con todas las relaciones
- Casts: fechas → datetime, es_invitado → boolean
- Relaciones: User, Room, Materials (pivote)"
```

#### FASE 3: Seeders

```bash
git commit -m "[FASE 3.1] Factory: Crear MaterialFactory

- Factory con datos realistas
- Categorías y estados aleatorios"

git commit -m "[FASE 3.1] Factory: Crear RoomFactory

- Factory con tipos de aula variados
- Equipamiento en formato JSON"

git commit -m "[FASE 3.1] Factory: Crear ReservationFactory

- Factory con fechas coherentes
- Estados aleatorios"

git commit -m "[FASE 3.2] Seeder: Crear SuperAdminSeeder

- Usuario permanente: superadmin@classy.local
- Password: SuperAdmin2026!
- ⚠️ NUNCA BORRAR"

git commit -m "[FASE 3.2] Seeder: Crear TestDataSeeder

- Datos marcados con [TEST] para fácil borrado
- 10 materiales, 5 aulas, 20 reservas de prueba
- Usuario test@classy.local"

git commit -m "[FASE 3.2] Seeder: Configurar DatabaseSeeder

- Llamar a SuperAdminSeeder siempre
- TestDataSeeder solo en local
- Documentar comando de limpieza"
```

#### FASE 4: Resources

```bash
git commit -m "[FASE 4] Resource: Crear UserResource

- Exponer: id, name, email, role, department
- Ocultar: password, timestamps sensibles"

git commit -m "[FASE 4] Resource: Crear MaterialResource

- Todos los campos visibles
- Formatear disponible como boolean"

git commit -m "[FASE 4] Resource: Crear RoomResource

- Incluir equipamiento parseado
- Formatear capacidad y disponibilidad"

git commit -m "[FASE 4] Resource: Crear ReservationResource y DetailResource

- ReservationResource: datos básicos
- DetailResource: incluir relaciones completas (user, room, materials)"
```

#### FASE 5: Validaciones

```bash
git commit -m "[FASE 5] Request: Crear LoginRequest

- Validar email y password
- Mensajes en español"

git commit -m "[FASE 5] Request: Crear StoreUserRequest y UpdateUserRequest

- Validación de email unique
- Password hasheado, confirmación requerida
- Department nullable"

git commit -m "[FASE 5] Request: Crear StoreMaterialRequest y UpdateMaterialRequest

- Codigo unique
- Categorías y estados enum
- Validación completa"

git commit -m "[FASE 5] Request: Crear StoreRoomRequest y UpdateRoomRequest

- Capacidad como integer
- Equipamiento como array/json
- Validación completa"

git commit -m "[FASE 5] Request: Crear StoreReservationRequest y UpdateReservationRequest

- Validación custom: room_id O material_ids required
- Fecha_fin after fecha_inicio
- User y materiales existen en BD"
```

#### FASE 6: Controladores

```bash
git commit -m "[FASE 6.1] Controller: Crear AuthController

- Login con generación de token
- Logout con invalidación
- Endpoint /api/user para obtener usuario actual"

git commit -m "[FASE 6.2] Controller: Crear UserController

- CRUD completo
- Password hasheado en store/update
- UserResource en respuestas"

git commit -m "[FASE 6.3] Controller: Crear MaterialController

- CRUD completo
- Métodos especiales: search, findByBarcode
- MaterialResource en respuestas"

git commit -m "[FASE 6.4] Controller: Crear RoomController

- CRUD completo
- RoomResource en respuestas"

git commit -m "[FASE 6.5] Controller: Crear ReservationController

- CRUD con eager loading de relaciones
- Método markAsReturned
- Sincronización de materiales con sync()
- ReservationDetailResource en respuestas"
```

#### FASE 7: Rutas

```bash
git commit -m "[FASE 7] Routes: Crear routes/api.php completo

- Rutas públicas: login, material index
- Rutas protegidas con auth:sanctum
- Rutas preparadas con middleware role (comentadas)"

git commit -m "[FASE 7] Routes: Registrar api.php en bootstrap

- Configurar en bootstrap/app.php
- Verificar prefix /api"
```

#### FASE 8: Lógica Especial

```bash
git commit -m "[FASE 8.1] Service: Crear ReservationValidationService

- Validar solapamiento de aulas
- Validar solapamiento de materiales
- Retornar errores 409 Conflict"

git commit -m "[FASE 8.2] Feature: Hash de contraseñas en UserController

- Hashear password en store
- Hashear solo si viene en update"

git commit -m "[FASE 8.3] Feature: Devolución de material en ReservationController

- Marcar reserva como completada
- Marcar materiales como disponibles"
```

#### FASE 9: Configuración Final

```bash
git commit -m "[FASE 9] Config: Configuración final de CORS

- Leer FRONTEND_URL desde .env
- Configurar allowed_origins
- supports_credentials = true"

git commit -m "[FASE 9] Config: Variables de entorno finales

- Actualizar .env con todas las variables
- Documentar en .env.example
- Sanctum stateful domains"

git commit -m "[FASE 9] DB: Ejecutar migraciones y seeders

- migrate:fresh ejecutado
- SuperAdmin creado
- Datos de prueba generados"
```

#### FASE 11: Activación de Permisos

```bash
git commit -m "[FASE 11] Security: Activar middleware de roles

- Descomentar rutas protegidas
- Mover rutas sensibles a grupos con role
- Verificar permisos admin/profesor"
```

### 🎯 Beneficios de esta Estrategia

- ✅ **Trazabilidad:** Cada cambio tiene contexto claro
- ✅ **Rollback fácil:** Deshacer un bloque específico sin afectar otros
- ✅ **Code Review:** Los compañeros pueden revisar commit por commit
- ✅ **Documentación:** El historial cuenta la historia del desarrollo
- ✅ **Debugging:** Fácil identificar cuándo se introdujo un bug

### 📌 Comandos Git Útiles

```bash
# Ver log con decoración
git log --oneline --graph --decorate

# Ver cambios de un commit específico
git show <commit-hash>

# Ver archivos modificados por fase
git log --grep="FASE 2" --oneline

# Deshacer último commit (manteniendo cambios)
git reset --soft HEAD~1

# Ver diff antes de commitear
git diff --staged
```

---

## 📊 Estructura de Datos Actualizada

### Tabla `users`

```php
id, name, email, password (hashed), role, department (nullable), timestamps
// Roles: 'admin', 'profesor'
// Password: hasheado en backend con bcrypt
```

### Tabla `materials`

```php
id, nombre, codigo (unique), barcode, categoria, estado, disponible (boolean), timestamps
// Categorías: 'Informática', 'Audiovisual', 'Mobiliario', 'Deportivo', 'Laboratorio', 'Otros'
// Estados: 'Excelente', 'Bueno', 'Regular', 'Malo'
```

### Tabla `rooms` (nueva)

```php
id, nombre, codigo, tipo, capacidad, ubicacion, disponible (boolean), equipamiento (json/text), timestamps
// Tipos: 'Teórica', 'Laboratorio', 'Informática', 'Taller', 'Auditorio', 'Estudio'
```

### Tabla `reservations` (unificada)

```php
id, user_id, room_id (nullable), fecha_inicio, fecha_fin, estado, observaciones, es_invitado (boolean), timestamps
// Estados: 'activa', 'cancelada', 'completada', 'pendiente'
// room_id es nullable porque puede ser solo préstamo de material
```

### Tabla `material_reservation` (pivote - muchos-a-muchos)

```php
id, reservation_id, material_id, timestamps
// Permite que una reserva tenga múltiples materiales
// En el futuro se puede extender para añadir cantidad, etc.
```

---

## 🔄 Validaciones: Form Requests

```php
// app/Http/Requests/StoreMaterialRequest.php
class StoreMaterialRequest extends FormRequest {
    public function authorize() {
        // Autorización previa (ej: solo admin puede crear)
        return true;
    }

    public function rules() {
        return [
            'nombre' => 'required|string|min:3|max:255',
            'codigo' => 'required|string|unique:materials|max:50',
            'barcode' => 'nullable|string|max:100',
            'categoria' => 'required|string',
            'estado' => 'required|string',
            'disponible' => 'required|boolean',
        ];
    }

    public function messages() {
        return [
            'nombre.required' => 'El nombre del material es obligatorio',
            'codigo.unique' => 'Ya existe un material con este código',
            'categoria.required' => 'Debe seleccionar una categoría',
        ];
    }
}

// Controlador queda súper limpio
public function store(StoreMaterialRequest $request) {
    $material = Material::create($request->validated());
    return new MaterialResource($material);
}
```

**PROS:**

- ✅ Controlador limpio (1-2 líneas)
- ✅ Validaciones reutilizables en múltiples métodos
- ✅ Mensajes personalizados centralizados en español
- ✅ Autorización incluida con método `authorize()`
- ✅ Fácil de mantener y modificar sin tocar el controlador
- ✅ Separación de responsabilidades (SRP)
- ✅ Permite validaciones complejas con métodos custom

**CONTRAS:**

- ⚠️ Más archivos (uno por tipo de validación)
- ⚠️ Requiere conocer convención de nombres

**Decisión:** Usaremos **Form Requests** para mantener el código limpio, profesional y mantenible.

---

## 📅 Plan de Implementación (Bottom-Up)

### **FASE 0: Puesta a Punto** ✅ (Pre-desarrollo)

> **Objetivo:** Verificar que el proyecto Laravel está en condiciones óptimas antes de empezar el desarrollo.

#### 0.1 Verificación del Entorno

- [x] Verificar que existe archivo `.env`
- [x] Verificar que `APP_KEY` está generada
- [x] Verificar que dependencias están instaladas (`vendor/`)
- [x] Verificar versión de Laravel (12.48.1)
- [x] Verificar versión de PHP (8.2.12)
- [x] Verificar Composer (2.9.4)

#### 0.2 Estado Actual del Proyecto

**✅ Funcionando:**

- Laravel Framework instalado y funcionando
- Estructura de carpetas correcta
- Autoload funcionando
- Composer scripts disponibles

**⚠️ Por Configurar (se hará en Fase 1):**

- Base de datos: actualmente MySQL → cambiar a SQLite
- Cache driver: database → funcionará con SQLite
- Session driver: database → funcionará con SQLite
- Queue driver: database → funcionará con SQLite

**📦 Paquetes Actuales:**

```json
"require": {
    "php": "^8.2",
    "laravel/framework": "^12.0",
    "laravel/tinker": "^2.10.1"
}
```

**🔜 Por Instalar (Fase 1.1):**

- `laravel/sanctum` para autenticación API

#### 0.3 Limpieza y Preparación

- [x] Verificar estado de Git (rama `SpeedRun`)
- [x] Identificar archivos sin trackear:
    - `GuiaBackend.md` ✅ (documentación del frontend)
    - `PlanDeTrabajo.md` ✅ (este documento)

#### 0.4 Decisiones de Fase 0

**✅ Lo que NO haremos ahora:**

- ❌ No instalar Sanctum (Fase 1.1)
- ❌ No modificar migraciones (Fase 2)
- ❌ No cambiar a SQLite todavía (Fase 1.1)
- ❌ No limpiar cachés (requiere BD configurada)

**✅ Lo que incluirá el commit de Fase 0:**

- Añadir `GuiaBackend.md` (referencia de la API del frontend)
- Añadir `PlanDeTrabajo.md` (este plan completo)
- Documentar estado inicial del proyecto

#### 0.5 Commit de Fase 0

```bash
git add GuiaBackend.md PlanDeTrabajo.md
git commit -m "[FASE 0] Docs: Añadir documentación y plan de trabajo

- GuiaBackend.md: Especificación de la API del frontend
- PlanDeTrabajo.md: Plan completo de desarrollo con estrategia de commits
- Estado verificado: Laravel 12.48.1 + PHP 8.2.12 funcionando
- Preparado para comenzar desarrollo"
```

---

### **FASE 1: Configuración Base** (Día 1)

#### 1.1 Configuración Inicial

- [ ] Configurar SQLite en `.env`
    ```env
    DB_CONNECTION=sqlite
    # Comentar o eliminar: DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD
    ```
- [ ] Crear archivo de base de datos SQLite
    ```bash
    touch database/database.sqlite
    ```
- [ ] Instalar Laravel Sanctum
    ```bash
    composer require laravel/sanctum
    php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
    ```
- [ ] Configurar CORS dinámico en `config/cors.php` (leer desde `.env`)
- [ ] Crear archivo `routes/api.php` si no existe
- [ ] Registrar `api.php` en `bootstrap/app.php`
- [ ] Añadir variables a `.env` y `.env.example`:
    ```env
    FRONTEND_URL=http://localhost:5173
    SANCTUM_STATEFUL_DOMAINS=localhost:5173
    SESSION_DRIVER=cookie
    ```

#### 1.2 Preparar Middleware

- [ ] Crear `app/Http/Middleware/RoleMiddleware.php` (preparado, sin usar)
- [ ] Registrar middleware en `bootstrap/app.php`

---

### **FASE 2: Base de Datos** (Día 1-2)

#### 2.1 Migraciones

##### A) Modificar Migraciones Existentes

- [ ] **MODIFICAR** `database/migrations/0001_01_01_000000_create_users_table.php`
    - ✅ Asegurar que `password` existe
    - ✅ Cambiar `role` enum a `['admin', 'profesor']`
    - ✅ Mantener `department` como nullable
- [ ] **MODIFICAR** `database/migrations/2026_01_23_121258_create_materials_table.php`
    - Renombrar `name` → `nombre`
    - Añadir: `codigo` (unique), `categoria`, `estado`, `disponible` (boolean)
    - Eliminar: `status`

##### B) Eliminar Migraciones Obsoletas

- [ ] **ELIMINAR** `database/migrations/2026_01_23_121432_create_material_loans_table.php`
- [ ] **ELIMINAR** `database/migrations/2026_01_23_121341_create_room_reservations_table.php`

##### C) Crear Nuevas Migraciones

- [ ] **CREAR** `database/migrations/2026_01_23_121003_create_rooms_table.php`
    ```bash
    php artisan make:migration create_rooms_table
    ```
    Campos: `nombre`, `codigo`, `tipo`, `capacidad`, `ubicacion`, `disponible`, `equipamiento`
- [ ] **CREAR** `database/migrations/2026_01_23_122000_create_reservations_table.php`
    ```bash
    php artisan make:migration create_reservations_table
    ```
    Campos: `user_id`, `room_id` (nullable), `fecha_inicio`, `fecha_fin`, `estado`, `observaciones`, `es_invitado`
- [ ] **CREAR** `database/migrations/2026_01_23_122100_create_material_reservation_table.php`
    ```bash
    php artisan make:migration create_material_reservation_table
    ```
    Campos: `reservation_id`, `material_id` (tabla pivote)

#### 2.2 Modelos

##### A) Modificar Modelos Existentes

- [ ] **MODIFICAR** `app/Models/User.php`
    - Añadir `use Laravel\Sanctum\HasApiTokens`
    - Añadir trait `HasApiTokens`
    - Añadir `department` a `$fillable`
    - Añadir relación: `public function reservations() { return $this->hasMany(Reservation::class); }`
- [ ] **MODIFICAR** `app/Models/Material.php`
    - Actualizar `$fillable` con: `['nombre', 'codigo', 'barcode', 'categoria', 'estado', 'disponible']`
    - Añadir cast: `'disponible' => 'boolean'`
    - Añadir relación: `public function reservations() { return $this->belongsToMany(Reservation::class, 'material_reservation'); }`

##### B) Eliminar Modelos Obsoletos

- [ ] **ELIMINAR** `app/Models/MaterialLoan.php`
- [ ] **ELIMINAR** `app/Models/RoomReservation.php`

##### C) Crear Nuevos Modelos

- [ ] **CREAR** `app/Models/Room.php`

    ```bash
    php artisan make:model Room
    ```

    - Fillable: todos los campos
    - Cast `equipamiento` a `array`
    - Cast `disponible` a `boolean`
    - Relación: `public function reservations() { return $this->hasMany(Reservation::class); }`

- [ ] **CREAR** `app/Models/Reservation.php`

    ```bash
    php artisan make:model Reservation
    ```

    - Fillable: todos los campos
    - Casts: `fecha_inicio` → `datetime`, `fecha_fin` → `datetime`, `es_invitado` → `boolean`
    - Relaciones:
        - `public function user() { return $this->belongsTo(User::class); }`
        - `public function room() { return $this->belongsTo(Room::class); }`
        - `public function materials() { return $this->belongsToMany(Material::class, 'material_reservation'); }`

---

### **FASE 3: Seeders** (Día 2)

#### 3.1 Factories

- [ ] **CREAR** `database/factories/MaterialFactory.php`
    ```bash
    php artisan make:factory MaterialFactory
    ```
- [ ] **CREAR** `database/factories/RoomFactory.php`
    ```bash
    php artisan make:factory RoomFactory
    ```
- [ ] **CREAR** `database/factories/ReservationFactory.php`
    ```bash
    php artisan make:factory ReservationFactory
    ```

#### 3.2 Seeders Marcados

- [ ] **CREAR** `database/seeders/SuperAdminSeeder.php` ⭐ **PERMANENTE**

    ```bash
    php artisan make:seeder SuperAdminSeeder
    ```

    - Usuario admin permanente:
        - Email: `superadmin@classy.local`
        - Password: `SuperAdmin2026!`
        - Name: `Super Admin`
        - Role: `admin`
        - Department: `Administración`
    - ⚠️ **NUNCA BORRAR ESTE USUARIO**

- [ ] **CREAR** `database/seeders/TestDataSeeder.php` ⚠️ **MARCADO PARA BORRAR**

    ```bash
    php artisan make:seeder TestDataSeeder
    ```

    - Usuario de prueba: `test@classy.local` / `test123`
    - 10-15 materiales con `[TEST]` en el nombre
    - 5-8 aulas con `[TEST]` en el nombre
    - 20-30 reservas de prueba con `[TEST]` en observaciones
    - Todos los datos deben ser fácilmente identificables y eliminables

- [ ] **MODIFICAR** `database/seeders/DatabaseSeeder.php`

    ```php
    $this->call(SuperAdminSeeder::class); // Siempre

    if (app()->environment('local')) {
        $this->call(TestDataSeeder::class); // Solo en local
    }
    ```

---

### **FASE 4: API Resources** (Día 3)

- [ ] **CREAR** `app/Http/Resources/UserResource.php`
    ```bash
    php artisan make:resource UserResource
    ```
    Exponer: `id`, `name`, `email`, `role`, `department`, `created_at`
- [ ] **CREAR** `app/Http/Resources/MaterialResource.php`
    ```bash
    php artisan make:resource MaterialResource
    ```
    Exponer: `id`, `nombre`, `codigo`, `barcode`, `categoria`, `estado`, `disponible`
- [ ] **CREAR** `app/Http/Resources/RoomResource.php`
    ```bash
    php artisan make:resource RoomResource
    ```
    Exponer: `id`, `nombre`, `codigo`, `tipo`, `capacidad`, `ubicacion`, `disponible`, `equipamiento`
- [ ] **CREAR** `app/Http/Resources/ReservationResource.php`
    ```bash
    php artisan make:resource ReservationResource
    ```
    Exponer: `id`, `user_id`, `room_id`, `fecha_inicio`, `fecha_fin`, `estado`, `observaciones`, `es_invitado`
- [ ] **CREAR** `app/Http/Resources/ReservationDetailResource.php`
    ```bash
    php artisan make:resource ReservationDetailResource
    ```
    Incluir objetos completos: `user`, `room`, `materials[]` (con relaciones eager loaded)

---

### **FASE 5: Form Requests** (Día 3)

#### Autenticación

- [ ] **CREAR** `app/Http/Requests/LoginRequest.php`
    ```bash
    php artisan make:request LoginRequest
    ```
    Validar: `email` (required, email), `password` (required, min:6)

#### Usuarios

- [ ] **CREAR** `app/Http/Requests/StoreUserRequest.php`
    ```bash
    php artisan make:request StoreUserRequest
    ```
    Validar: `name`, `email` (unique), `password` (min:8, confirmed), `role`, `department` (nullable)
- [ ] **CREAR** `app/Http/Requests/UpdateUserRequest.php`
    ```bash
    php artisan make:request UpdateUserRequest
    ```
    Validar: `name`, `email` (unique except self), `password` (nullable, min:8, confirmed), `role`, `department`

#### Material

- [ ] **CREAR** `app/Http/Requests/StoreMaterialRequest.php`
    ```bash
    php artisan make:request StoreMaterialRequest
    ```
    Validar: `nombre`, `codigo` (unique), `barcode`, `categoria`, `estado`, `disponible`
- [ ] **CREAR** `app/Http/Requests/UpdateMaterialRequest.php`
    ```bash
    php artisan make:request UpdateMaterialRequest
    ```
    Validar: igual que Store pero `codigo` unique except self

#### Aulas

- [ ] **CREAR** `app/Http/Requests/StoreRoomRequest.php`
    ```bash
    php artisan make:request StoreRoomRequest
    ```
    Validar: `nombre`, `codigo`, `tipo`, `capacidad` (integer), `ubicacion`, `disponible`, `equipamiento`
- [ ] **CREAR** `app/Http/Requests/UpdateRoomRequest.php`
    ```bash
    php artisan make:request UpdateRoomRequest
    ```
    Validar: igual que Store

#### Reservas

- [ ] **CREAR** `app/Http/Requests/StoreReservationRequest.php`
    ```bash
    php artisan make:request StoreReservationRequest
    ```
    Validar:
    - `user_id` (exists:users,id)
    - `room_id` (nullable, exists:rooms,id)
    - `material_ids` (nullable, array)
    - `material_ids.*` (exists:materials,id)
    - `fecha_inicio` (required, date)
    - `fecha_fin` (required, date, after:fecha_inicio)
    - `estado` (required, in:activa,pendiente,cancelada,completada)
    - `observaciones` (nullable, string)
    - `es_invitado` (boolean)
    - Validación custom: al menos `room_id` o `material_ids[]` debe existir
- [ ] **CREAR** `app/Http/Requests/UpdateReservationRequest.php`
    ```bash
    php artisan make:request UpdateReservationRequest
    ```
    Validar: igual que Store

---

### **FASE 6: Controladores** (Día 4-5)

#### 6.1 Autenticación

- [ ] **CREAR** `app/Http/Controllers/Api/AuthController.php`
    ```bash
    php artisan make:controller Api/AuthController
    ```
    Métodos:
    - `login(LoginRequest $request)` - POST `/api/login`
        - Validar credenciales con `Auth::attempt()`
        - Retornar token: `$user->createToken('auth-token')->plainTextToken`
        - Retornar: `{ token, user: UserResource }`
    - `logout(Request $request)` - POST `/api/logout`
        - `$request->user()->currentAccessToken()->delete()`
    - `user(Request $request)` - GET `/api/user`
        - Retornar: `new UserResource($request->user())`

#### 6.2 Usuarios

- [ ] **CREAR** `app/Http/Controllers/Api/UserController.php`
    ```bash
    php artisan make:controller Api/UserController --api
    ```
    Métodos:
    - `index()` - GET `/api/users` - Retornar: `UserResource::collection(User::all())`
    - `show($id)` - GET `/api/users/:id` - Retornar: `new UserResource($user)`
    - `store(StoreUserRequest $request)` - POST `/api/users` - Crear usuario con password hasheado
    - `update(UpdateUserRequest $request, $id)` - PUT `/api/users/:id` - Actualizar (hashear password si viene)
    - `destroy($id)` - DELETE `/api/users/:id` - Soft delete o hard delete

#### 6.3 Material

- [ ] **CREAR** `app/Http/Controllers/Api/MaterialController.php`
    ```bash
    php artisan make:controller Api/MaterialController --api
    ```
    Métodos:
    - `index()` - GET `/api/material` - Retornar: `MaterialResource::collection()`
    - `show($id)` - GET `/api/material/:id`
    - `store(StoreMaterialRequest $request)` - POST `/api/material`
    - `update(UpdateMaterialRequest $request, $id)` - PUT `/api/material/:id`
    - `destroy($id)` - DELETE `/api/material/:id`
    - `search(Request $request)` - GET `/api/material/search?q=`
        - Buscar en: `nombre`, `codigo`, `barcode`, `categoria`
    - `findByBarcode($barcode)` - GET `/api/material/barcode/:barcode`
        - Buscar por código de barras exacto

#### 6.4 Aulas

- [ ] **CREAR** `app/Http/Controllers/Api/RoomController.php`
    ```bash
    php artisan make:controller Api/RoomController --api
    ```
    Métodos:
    - `index()` - GET `/api/aulas`
    - `show($id)` - GET `/api/aulas/:id`
    - `store(StoreRoomRequest $request)` - POST `/api/aulas`
    - `update(UpdateRoomRequest $request, $id)` - PUT `/api/aulas/:id`
    - `destroy($id)` - DELETE `/api/aulas/:id`

#### 6.5 Reservas

- [ ] **CREAR** `app/Http/Controllers/Api/ReservationController.php`
    ```bash
    php artisan make:controller Api/ReservationController --api
    ```
    Métodos:
    - `index()` - GET `/api/reservas`
        - Eager load: `with(['user', 'room', 'materials'])`
        - Retornar: `ReservationDetailResource::collection()`
    - `show($id)` - GET `/api/reservas/:id`
        - Eager load relaciones
        - Retornar: `new ReservationDetailResource($reservation)`
    - `store(StoreReservationRequest $request)` - POST `/api/reservas`
        - Crear reserva
        - Adjuntar materiales: `$reservation->materials()->attach($request->material_ids)`
        - Validar solapamientos (usar Service)
    - `update(UpdateReservationRequest $request, $id)` - PUT `/api/reservas/:id`
        - Actualizar reserva
        - Sincronizar materiales: `$reservation->materials()->sync($request->material_ids)`
    - `destroy($id)` - DELETE `/api/reservas/:id`
    - `markAsReturned($id)` - POST `/api/reservas/:id/devolver`
        - Cambiar `estado` a `completada`
        - Marcar materiales como disponibles: `disponible = true`

---

### **FASE 7: Rutas** (Día 5)

- [ ] **CREAR/MODIFICAR** `routes/api.php`

    ```php
    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\AuthController;
    use App\Http\Controllers\Api\UserController;
    use App\Http\Controllers\Api\MaterialController;
    use App\Http\Controllers\Api\RoomController;
    use App\Http\Controllers\Api\ReservationController;

    // ========================================
    // RUTAS PÚBLICAS
    // ========================================
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/material', [MaterialController::class, 'index']); // Lista pública

    // ========================================
    // RUTAS PROTEGIDAS (Sanctum)
    // ========================================
    Route::middleware('auth:sanctum')->group(function () {

        // Auth
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);

        // Usuarios
        Route::apiResource('users', UserController::class);

        // Material
        Route::get('/material/search', [MaterialController::class, 'search']);
        Route::get('/material/barcode/{barcode}', [MaterialController::class, 'findByBarcode']);
        Route::apiResource('material', MaterialController::class)->except(['index']);

        // Aulas
        Route::apiResource('aulas', RoomController::class);

        // Reservas
        Route::post('/reservas/{id}/devolver', [ReservationController::class, 'markAsReturned']);
        Route::apiResource('reservas', ReservationController::class);

    });

    // ========================================
    // RUTAS CON MIDDLEWARE DE ROLES (PREPARADAS - SIN ACTIVAR)
    // ========================================
    // Descomentar cuando se quiera activar el sistema de permisos

    /*
    Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
        // Solo admins
        Route::apiResource('users', UserController::class);
        Route::apiResource('material', MaterialController::class)->except(['index']);
        Route::apiResource('aulas', RoomController::class);
    });

    Route::middleware(['auth:sanctum', 'role:admin,profesor'])->group(function () {
        // Admins y profesores
        Route::apiResource('reservas', ReservationController::class);
        Route::post('/reservas/{id}/devolver', [ReservationController::class, 'markAsReturned']);
    });
    */
    ```

- [ ] **VERIFICAR** que `routes/api.php` está registrado en `bootstrap/app.php`

---

### **FASE 8: Lógica Especial** (Día 6)

#### 8.1 Service de Validación de Solapamientos

- [ ] **CREAR** `app/Services/ReservationValidationService.php`
    ```bash
    mkdir app/Services
    # Crear archivo manualmente
    ```
    Métodos:
    - `checkRoomOverlap($room_id, $start, $end, $exclude_id = null)`
        - Buscar reservas del mismo aula que solapen fechas
        - Retornar true si hay solapamiento
    - `checkMaterialsOverlap($material_ids, $start, $end, $exclude_id = null)`
        - Buscar reservas de los mismos materiales que solapen
        - Retornar array de materiales que tienen conflicto
    - Usar en `ReservationController` antes de crear/actualizar

#### 8.2 Hash de Contraseñas

- [ ] **VERIFICAR** en `User` model que usa trait `Authenticatable`
- [ ] **MODIFICAR** `UserController@store`
    ```php
    $data = $request->validated();
    $data['password'] = bcrypt($data['password']);
    $user = User::create($data);
    ```
- [ ] **MODIFICAR** `UserController@update`
    ```php
    $data = $request->validated();
    if (isset($data['password'])) {
        $data['password'] = bcrypt($data['password']);
    } else {
        unset($data['password']); // No actualizar si no viene
    }
    $user->update($data);
    ```

#### 8.3 Devolución de Material

- [ ] **IMPLEMENTAR** `ReservationController@markAsReturned`

    ```php
    public function markAsReturned($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Cambiar estado de la reserva
        $reservation->update(['estado' => 'completada']);

        // Marcar todos los materiales como disponibles
        foreach ($reservation->materials as $material) {
            $material->update(['disponible' => true]);
        }

        return new ReservationDetailResource($reservation->fresh());
    }
    ```

---

### **FASE 9: Configuración Final** (Día 6)

#### 9.1 CORS

- [ ] **MODIFICAR** `config/cors.php`

    ```php
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:5173')],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
    ```

#### 9.2 Variables de Entorno

- [ ] **MODIFICAR** `.env`

    ```env
    APP_NAME=Laravel
    APP_ENV=local
    APP_KEY=base64:...
    APP_DEBUG=true
    APP_URL=http://localhost:8000

    DB_CONNECTION=sqlite
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=laravel
    # DB_USERNAME=root
    # DB_PASSWORD=

    SANCTUM_STATEFUL_DOMAINS=localhost:5173
    SESSION_DRIVER=cookie

    FRONTEND_URL=http://localhost:5173
    ```

- [ ] **ACTUALIZAR** `.env.example` con las mismas variables

#### 9.3 Sanctum Configuration

- [ ] **VERIFICAR** `config/sanctum.php`
    ```php
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,localhost:5173,127.0.0.1,127.0.0.1:8000,::1',
        Sanctum::currentApplicationUrlWithPort()
    ))),
    ```

#### 9.4 Ejecutar Migraciones y Seeders

- [ ] Resetear base de datos
    ```bash
    php artisan migrate:fresh
    ```
- [ ] Ejecutar seeders
    ```bash
    php artisan db:seed
    ```
- [ ] Verificar que se creó el superadmin y datos de prueba

---

### **FASE 10: Pruebas Manuales** (Día 7)

#### 10.1 Configurar Postman/Insomnia

- [ ] Crear colección "Classy API"
- [ ] Configurar variable `{{base_url}}` = `http://localhost:8000/api`
- [ ] Configurar variable `{{token}}` (se llenará después del login)

#### 10.2 Probar Autenticación

- [ ] **POST** `/login`
    ```json
    {
        "email": "superadmin@classy.local",
        "password": "SuperAdmin2026!"
    }
    ```
    Verificar: retorna `token` y `user`
- [ ] Guardar token en variable `{{token}}`
- [ ] **GET** `/user` con header `Authorization: Bearer {{token}}`
      Verificar: retorna datos del usuario logueado
- [ ] **POST** `/logout` con token
      Verificar: token se invalida

#### 10.3 Probar CRUD Usuarios

- [ ] **GET** `/users` - Listar todos
- [ ] **POST** `/users` - Crear nuevo profesor
    ```json
    {
        "name": "Profesor Test",
        "email": "profesor@test.com",
        "password": "password123",
        "password_confirmation": "password123",
        "role": "profesor",
        "department": "Matemáticas"
    }
    ```
- [ ] **GET** `/users/{id}` - Ver uno específico
- [ ] **PUT** `/users/{id}` - Actualizar
- [ ] **DELETE** `/users/{id}` - Eliminar

#### 10.4 Probar CRUD Material

- [ ] **GET** `/material` - Listar (sin token, público)
- [ ] **POST** `/material` - Crear
- [ ] **GET** `/material/{id}` - Ver uno
- [ ] **GET** `/material/search?q=laptop` - Buscar
- [ ] **GET** `/material/barcode/12345` - Buscar por código de barras
- [ ] **PUT** `/material/{id}` - Actualizar
- [ ] **DELETE** `/material/{id}` - Eliminar

#### 10.5 Probar CRUD Aulas

- [ ] **GET** `/aulas` - Listar
- [ ] **POST** `/aulas` - Crear
- [ ] **GET** `/aulas/{id}` - Ver una
- [ ] **PUT** `/aulas/{id}` - Actualizar
- [ ] **DELETE** `/aulas/{id}` - Eliminar

#### 10.6 Probar CRUD Reservas

- [ ] **GET** `/reservas` - Listar (verificar que incluye relaciones)
- [ ] **POST** `/reservas` - Crear reserva solo de aula
    ```json
    {
        "user_id": 1,
        "room_id": 1,
        "fecha_inicio": "2026-02-15 09:00:00",
        "fecha_fin": "2026-02-15 11:00:00",
        "estado": "activa",
        "es_invitado": false
    }
    ```
- [ ] **POST** `/reservas` - Crear reserva solo de materiales
    ```json
    {
        "user_id": 1,
        "material_ids": [1, 2, 3],
        "fecha_inicio": "2026-02-15 09:00:00",
        "fecha_fin": "2026-02-15 11:00:00",
        "estado": "activa",
        "es_invitado": false
    }
    ```
- [ ] **POST** `/reservas` - Crear reserva de aula + materiales
- [ ] **GET** `/reservas/{id}` - Ver una (verificar relaciones completas)
- [ ] **PUT** `/reservas/{id}` - Actualizar
- [ ] **POST** `/reservas/{id}/devolver` - Marcar como devuelta
      Verificar: estado cambia a 'completada' y materiales a 'disponible'
- [ ] **DELETE** `/reservas/{id}` - Eliminar

#### 10.7 Probar Validaciones

- [ ] Intentar crear material sin `nombre` - Verificar error 422
- [ ] Intentar crear usuario con email duplicado - Verificar error 422
- [ ] Intentar crear reserva sin `room_id` ni `material_ids` - Verificar error
- [ ] Intentar superponer reservas del mismo aula - Verificar error de solapamiento

#### 10.8 Conectar con Frontend

- [ ] Levantar frontend en `http://localhost:5173`
- [ ] Probar login desde el frontend
- [ ] Probar operaciones CRUD básicas
- [ ] Verificar que CORS funciona correctamente
- [ ] Verificar formato de respuestas coincide con lo esperado

---

### **FASE 11: Activar Permisos** (Día 8)

#### 11.1 Revisar Middleware de Roles

- [ ] Verificar `RoleMiddleware` funciona correctamente
- [ ] Testear con diferentes roles

#### 11.2 Mover Rutas Protegidas

- [ ] Descomentar sección de rutas con middleware de roles en `routes/api.php`
- [ ] Comentar las rutas que ahora están duplicadas

#### 11.3 Definir Permisos

- [ ] **Solo ADMIN puede:**
    - Crear/editar/eliminar usuarios
    - Crear/editar/eliminar materiales
    - Crear/editar/eliminar aulas
- [ ] **ADMIN y PROFESOR pueden:**
    - Crear/editar sus propias reservas
    - Ver todas las reservas
    - Marcar reservas como devueltas
- [ ] **TODOS (sin autenticar) pueden:**
    - Ver lista de materiales (para búsquedas públicas)

#### 11.4 Probar Permisos

- [ ] Crear usuario con rol `profesor`
- [ ] Intentar crear un material como profesor → Debería fallar (403)
- [ ] Intentar crear una reserva como profesor → Debería funcionar
- [ ] Intentar crear usuario como profesor → Debería fallar (403)
- [ ] Hacer las mismas pruebas como `admin` → Todo debería funcionar

---

## ⚠️ Notas Importantes

### 🗑️ Datos de Prueba - BORRADO FÁCIL

Para eliminar todos los datos de prueba antes del despliegue:

```sql
-- SQL Manual
DELETE FROM users WHERE email LIKE '%test%' OR name LIKE '[TEST]%';
DELETE FROM materials WHERE nombre LIKE '[TEST]%';
DELETE FROM rooms WHERE nombre LIKE '[TEST]%';
DELETE FROM reservations WHERE observaciones LIKE '[TEST]%';
DELETE FROM material_reservation WHERE reservation_id IN (
    SELECT id FROM reservations WHERE observaciones LIKE '[TEST]%'
);
```

O mejor, crear un comando Artisan:

```bash
php artisan make:command CleanTestData
```

```php
// app/Console/Commands/CleanTestData.php
public function handle()
{
    DB::table('users')->where('email', 'LIKE', '%test%')->delete();
    DB::table('materials')->where('nombre', 'LIKE', '[TEST]%')->delete();
    DB::table('rooms')->where('nombre', 'LIKE', '[TEST]%')->delete();
    // ... etc

    $this->info('Test data cleaned successfully!');
}
```

Ejecutar: `php artisan clean:test-data`

---

### 🔐 Superadmin Permanente

```
Email: superadmin@classy.local
Password: SuperAdmin2026!
Name: Super Admin
Role: admin
Department: Administración
```

**⚠️ NUNCA BORRAR ESTE USUARIO**

Este usuario es necesario para:

- Crear otros usuarios (la app solo permite crear usuarios si eres admin)
- Acceder al sistema después de limpiar datos de prueba
- Recuperación en caso de problemas

---

### 🔄 Relación Muchos-a-Muchos de Materiales

La tabla `material_reservation` permite que una reserva tenga múltiples materiales.

**Actualmente:**

```json
POST /api/reservas
{
  "material_ids": [1, 2, 3]
}
```

**Futuro (si se necesita):**
Se puede extender la tabla pivote para añadir:

- `cantidad` (cantidad de unidades del material)
- `estado_devolucion` (cómo se devolvió: "perfecto", "dañado", etc.)

```php migration
Schema::create('material_reservation', function (Blueprint $table) {
    $table->id();
    $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
    $table->foreignId('material_id')->constrained()->onDelete('cascade');
    $table->integer('cantidad')->default(1); // FUTURO
    $table->string('estado_devolucion')->nullable(); // FUTURO
    $table->timestamps();
});
```

---

### 🌐 Frontend Compatibility

El frontend (JSON Server mock) espera:

- Endpoint `/api/aulas` (no `/api/rooms`)
- Nombres de campos en español: `nombre`, `codigo`, `categoria`
- Formato de fechas ISO 8601: `2026-02-15T09:00:00.000Z`
- API Resources deben formatea correctamente

**Diferencias a tener en cuenta:**

- JSON Server usa `id` numéricos secuenciales
- Laravel usa UUIDs o IDs incrementales (mantener numéricos para compatibilidad)
- JSON Server retorna arrays directos, Laravel retorna objetos con `data`

---

## 📦 Comandos Útiles

### Crear Recursos

```bash
# Migración
php artisan make:migration create_reservations_table

# Modelo con migración, factory, seeder, controller
php artisan make:model Reservation -mfsc

# Modelo con todo + API controller
php artisan make:model Reservation -a --api

# Controller API
php artisan make:controller Api/UserController --api

# Form Request
php artisan make:request StoreMaterialRequest

# API Resource
php artisan make:resource MaterialResource

# Resource Collection
php artisan make:resource MaterialCollection

# Seeder
php artisan make:seeder TestDataSeeder

# Factory
php artisan make:factory MaterialFactory

# Middleware
php artisan make:middleware RoleMiddleware

# Command
php artisan make:command CleanTestData
```

### Base de Datos

```bash
# Migrar
php artisan migrate

# Migrar y hacer seed
php artisan migrate --seed

# Resetear BD completa y hacer seed
php artisan migrate:fresh --seed

# Solo seeders
php artisan db:seed

# Seeder específico
php artisan db:seed --class=SuperAdminSeeder

# Rollback última migración
php artisan migrate:rollback

# Rollback todas las migraciones
php artisan migrate:reset
```

### Información

```bash
# Ver rutas API
php artisan route:list --path=api

# Ver todas las rutas con detalles
php artisan route:list -v

# Ver solo rutas de un controlador
php artisan route:list --name=users

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Ver info de BD
php artisan db:show

# Ver tablas
php artisan db:table users
```

### Desarrollo

```bash
# Servidor de desarrollo
php artisan serve

# Servidor en puerto específico
php artisan serve --port=8080

# Modo interactivo (Tinker)
php artisan tinker

# En Tinker, probar cosas:
>>> User::count()
>>> Material::where('disponible', true)->get()
>>> $user = User::find(1)
>>> $user->reservations
```

---

## 🎯 Checklist Final de Despliegue

### Pre-Despliegue

- [ ] Todas las migraciones ejecutadas sin errores
- [ ] Todos los modelos con relaciones correctas funcionando
- [ ] Todos los controladores implementados y probados
- [ ] Todas las rutas funcionando correctamente
- [ ] Sanctum configurado y tokens funcionando
- [ ] CORS configurado para producción
- [ ] Validaciones funcionando en todos los endpoints
- [ ] API Resources retornando formato correcto
- [ ] Seeders ejecutados (solo SuperAdminSeeder en producción)
- [ ] Frontend conectado y probado completamente
- [ ] Middleware de roles funcionando correctamente
- [ ] Documentación `.env.example` actualizada

### Limpieza Pre-Producción

- [ ] Ejecutar `php artisan clean:test-data` (si creaste el comando)
- [ ] O ejecutar SQL manual para borrar datos `[TEST]`
- [ ] Verificar que existe el superadmin
- [ ] Cambiar `APP_ENV=production` en `.env`
- [ ] Cambiar `APP_DEBUG=false` en `.env`
- [ ] Generar nueva `APP_KEY` si es necesario
- [ ] Configurar `FRONTEND_URL` con la URL real de producción
- [ ] Probar login con superadmin

### Producción

- [ ] Subir código a servidor
- [ ] Configurar `.env` en servidor
- [ ] Ejecutar `composer install --no-dev`
- [ ] Ejecutar `php artisan migrate --force`
- [ ] Ejecutar `php artisan db:seed --class=SuperAdminSeeder --force`
- [ ] Ejecutar `php artisan config:cache`
- [ ] Ejecutar `php artisan route:cache`
- [ ] Configurar permisos de carpetas `storage/` y `bootstrap/cache/`
- [ ] Configurar servidor web (Nginx/Apache)
- [ ] Configurar SSL/HTTPS
- [ ] Probar todos los endpoints desde producción
- [ ] Monitorear logs: `storage/logs/laravel.log`

---

## 📊 Progreso Actual

**FASE 0:** ✅✅✅✅✅✅✅✅✅✅ 100% ✅ **COMPLETADA**  
**FASE 1:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%  
**FASE 2:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%  
**FASE 3:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%  
**FASE 4:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%  
**FASE 5:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%  
**FASE 6:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%  
**FASE 7:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%  
**FASE 8:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%  
**FASE 9:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%  
**FASE 10:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%  
**FASE 11:** ⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️⬜️ 0%

**TOTAL:** 8.3% Completo

---

## 🚀 Próximo Paso

**COMPLETADO:** ✅ FASE 0 - Puesta a Punto  
**SIGUIENTE:** 🎯 FASE 1.1 - Configuración Inicial

### Tareas Pendientes:

1. Configurar SQLite en `.env`
2. Crear archivo `database/database.sqlite`
3. Instalar Laravel Sanctum

**¿Continuamos con FASE 1.1?** 🚀
