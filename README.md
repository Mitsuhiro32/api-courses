# API Gestión de Cursos y Estudiantes

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Acerca de

Bienvenido a la documentación de la API de Cursos. Esta API permite gestionar cursos y estudiantes incluyendo operaciones para crear, leer, actualizar y eliminar.

## Tabla de Contenidos

- [API Gestión de Cursos y Estudiantes](#api-gestión-de-cursos-y-estudiantes)
  - [Acerca de](#acerca-de)
  - [Tabla de Contenidos](#tabla-de-contenidos)
  - [Requisitos](#requisitos)
  - [Instalación](#instalación)
  - [Configuración](#configuración)
  - [Ejecución](#ejecución)
  - [Endpoints](#endpoints)
    - [Cursos](#cursos)
    - [Estudiantes](#estudiantes)
    - [Inscripciones](#inscripciones)
  - [Autenticación](#autenticación)

---

## Requisitos

- PHP >= 8.1
- Composer
- MySQL o PostgreSQL
- Laravel >= 10

## Instalación

1. Clona el repositorio:

    ```bash
    git clone https://github.com/tu-usuario/api-cursos.git
    cd api-cursos
    ```

2. Instala las dependencias:

    ```bash
    composer install
    ```

3. Copia el archivo de entorno y configura tus variables:

    ```bash
    cp .env.example .env
    ```

4. Genera la clave de la aplicación:

    ```bash
    php artisan key:generate
    ```

## Configuración

Edita el archivo `.env` para configurar la conexión a la base de datos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=api_cursos
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```

Ejecuta las migraciones:

```bash
php artisan migrate
```

## Ejecución

Inicia el servidor de desarrollo:

```bash
php artisan serve
```

La API estará disponible en `http://localhost:8000`.

## Endpoints

### Cursos

- `GET /api/courses` — Listar todos los cursos
- `GET /api/courses/{id}` — Obtener detalles de un curso
- `POST /api/courses` — Crear un nuevo curso
- `PUT /api/courses/{id}` — Actualizar un curso existente
- `DELETE /api/courses/{id}` — Eliminar un curso

### Estudiantes

- `GET /api/students` — Listar todos los estudiantes
- `GET /api/students/{id}` — Obtener detalles de un estudiante
- `POST /api/students` — Crear un nuevo estudiante
- `PUT /api/students/{id}` — Actualizar un estudiante existente
- `DELETE /api/students/{id}` — Eliminar un estudiante

### Inscripciones

- `GET /api/enrollments` — Listar todas las inscripciones
  - `GET /api/enrollments?student_id=1` — Listar cursos donde está inscrito un estudiante
  - `GET /api/enrollments?course_id=1` — Listar estudiantes inscritos en un curso
- `POST /api/enrollments` — Crear una nueva inscripción
- `DELETE /api/enrollments/{id}` — Eliminar una inscripción

## Autenticación

La API utiliza autenticación basada en tokens (Laravel Sanctum).

1. Registra un usuario:

    ```http
    POST /api/register
    ```

2. Inicia sesión para obtener un token:

    ```http
    POST /api/login
    ```

El token debe enviarse en el header `Authorization: Bearer {token}` en las peticiones protegidas.
