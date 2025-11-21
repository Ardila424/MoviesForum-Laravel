# 🎬 Movies Blog - Sistema de Reseñas de Películas

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

**Movies Blog** es una plataforma web para la gestión y publicación de reseñas de películas, desarrollada con Laravel 11. Incluye un potente sistema de administración con permisos granulares, integración con la API de TMDB (The Movie Database), y una interfaz moderna con temática morada. 

---

## ✨ Características Principales

### 🎯 Funcionalidades Core
- ✅ **Sistema de Blogs/Reseñas** - Creación, edición y publicación de reseñas de películas
- ✅ **Integración TMDB** - Búsqueda automática de películas con datos actualizados desde la API de TMDB
- ✅ **Gestión de Secciones** - Categorización del blog. Ejemplo: Noticias, Reseñas, Estrenos, Trailers
- ✅ **Sistema de Calificaciones** - Rating de 1-10 para cada película
- ✅ **Sistema de Comentarios** - Comentarios en blogs para usuarios autenticados y visitantes
- ✅ **Búsqueda de Películas** - Búsqueda en tiempo real con la API de TMDB
- ✅ **Sistema de Favoritos** - Guarda tus películas favoritas con información de TMDB

### 🔐 Sistema de Permisos
- ✅ **Permisos Granulares** - Sistema `Módulo.Acción` (ej: `Blogs.createBlogs`)
- ✅ **Tres Roles Predefinidos**:
  - **Administrador** - Acceso completo al sistema, puede gestionar todos los blogs y secciones
  - **Editor** - Creación y edición de sus propios blogs
  - **Visitante** - Solo lectura de contenido público
- ✅ **Middleware Personalizado** - Autorización en cada ruta

### 👥 Panel de Administración
- ✅ **Gestión de Usuarios** - CRUD completo con asignación de roles
- ✅ **Gestión de Roles** - Creación, edición y eliminación de roles
- ✅ **Gestión de Permisos** - Asignación dinámica de permisos a roles
- ✅ **Dashboard con Métricas** - Estadísticas del sistema

### 🎨 Diseño y UX
- ✅ **Tema Morado** - Interfaz clara y simplista con un tono morado
- ✅ **Navegación por Roles** - Menús adaptados según permisos (Admin, Editor, Visitante)
- ✅ **Validaciones Robustas** - Feedback visual de errores en tiempo real

---

## 🛠️ Tecnologías Utilizadas

| Categoría | Tecnología |
|-----------|------------|
| **Backend** | [Laravel 11.x](https://laravel.com/), PHP 8.2+ |
| **Frontend** | [Blade Templates](https://laravel.com/docs/11.x/blade), [Tailwind CSS](https://tailwindcss.com/) |
| **Base de Datos** | [MySQL 8.0+](https://www.mysql.com/) |
| **Autenticación** | [Laravel Breeze](https://github.com/laravel/breeze) |
| **API Externa** | [TMDB API v3](https://www.themoviedb.org/) |
| **Build Tools** | [Vite](https://vite.dev/), npm |

---

## 📋 Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

- **PHP** >= 8.2
- **Composer** - Gestor de dependencias de PHP
- **Node.js** >= 18.x y npm
- **MySQL** >= 8.0 o MariaDB
- **WAMP/XAMPP/Laragon** (o servidor web de tu preferencia)
- **Git** - Para clonar el repositorio

---

## 🚀 Instalación Paso a Paso

### 1️⃣ Clonar el Repositorio
```bash
git clone https://github.com/Ardila424/MoviesForum-Laravel.git
cd MoviesForum-Laravel/MoviesBlog
```

### 2️⃣ Instalar Dependencias de PHP
```bash
composer install
```

### 3️⃣ Instalar Dependencias de Node.js
```bash
npm install
```

### 4️⃣ Configurar Variables de Entorno
```bash
# Copiar archivo de ejemplo
copy .env.example .env

# Generar key de aplicación
php artisan key:generate
```

### 5️⃣ Configurar Base de Datos

Edita el archivo `.env` y configura tu base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=movies_blog
DB_USERNAME=root
DB_PASSWORD=
```

### 6️⃣ Configurar API de TMDB

1. Regístrate en [TMDB](https://www.themoviedb.org/) y obtén tu API Key
2. Agrega la key en tu archivo `.env`:

```env
TMDB_API_KEY=tu_api_key_aqui
TMDB_BASE_URL=https://api.themoviedb.org/3
```

### 7️⃣ Crear y Poblar la Base de Datos
```bash
# Ejecutar migraciones y seeders
php artisan migrate:fresh --seed
```

Este comando creará:
- ✅ Todas las tablas necesarias
- ✅ 3 roles (Administrador, Editor, Visitante)
- ✅ Permisos granulares
- ✅ 3 usuarios de prueba
- ✅ Secciones de películas
- ✅ Blogs de ejemplo

### 8️⃣ Compilar Assets
```bash
# Desarrollo (con hot reload)
npm run dev

# Producción
npm run build
```

### 9️⃣ Iniciar el Servidor
```bash
php artisan serve
```

La aplicación estará disponible en: **http://127.0.0.1:8000**

---

## 👤 Credenciales de Prueba

Usa estas credenciales para acceder al sistema:

| Rol | Email | Contraseña | Permisos |
|-----|-------|------------|----------|
| **Admin** | admin@example.com | password | Acceso completo |
| **Editor** | editor@example.com | password | Crear/editar sus blogs |
| **Visitante** | visitante@example.com | password | Solo lectura |

---

## 📖 Uso del Sistema

### Como Administrador
1. **Login** con credenciales de admin
2. Accede al menú desplegable **"Admin ▾"**
3. Gestiona:
   - 📝 Blogs/Reseñas
   - 📁 Secciones
   - 👥 Usuarios
   - 🛡️ Roles y Permisos

### Como Editor
1. **Login** con credenciales de editor
2. Click en **"Mis Blogs"** en la navbar
3. Crea y edita tus propias reseñas
4. Búsqueda de películas en TMDB integrada

### Crear una Reseña
1. Click en **"+ Nuevo Blog"**
2. Escribe el título y selecciona sección
3. *(Opcional)* Busca la película en TMDB
4. Escribe tu reseña y calificación
5. Publica inmediatamente o guarda como borrador

### 💬 Sistema de Comentarios

El sistema permite comentarios tanto de **usuarios autenticados** como de **visitantes**.

#### Comentar como Usuario Autenticado
1. Inicia sesión con cualquier cuenta (Admin, Editor o Visitante)
2. Navega a cualquier blog público
3. Desplázate a la sección de comentarios
4. Escribe tu comentario (mínimo 3 caracteres, máximo 1000)
5. Haz clic en **"Publicar Comentario"**
6. Tu nombre de usuario aparecerá automáticamente en el comentario

#### Comentar como Visitante (No Autenticado)
1. Navega a cualquier blog público sin iniciar sesión
2. Desplázate a la sección de comentarios
3. Completa el formulario:
   - **Nombre**: Tu nombre completo
   - **Email**: Tu correo electrónico (no se muestra públicamente)
   - **Comentario**: Tu mensaje (mínimo 3 caracteres, máximo 1000)
4. Haz clic en **"Publicar Comentario"**
5. Tu comentario se publicará con el nombre que proporcionaste

**Características:**
- ✅ Sin necesidad de cuenta para comentar
- ✅ Validación de contenido (anti-spam básico)
- ✅ Comentarios ordenados por fecha (más recientes primero)
- ✅ Identificación clara entre usuarios registrados y visitantes

### 🎬 Búsqueda y Favoritos de Películas

Sistema completo de búsqueda y gestión de películas favoritas con datos actualizados de TMDB.

#### Buscar Películas
1. **Acceso**: Solo usuarios autenticados
2. Navega a **"Buscar Películas"** en la barra de navegación
3. Escribe el título de la película en el buscador
4. Los resultados se actualizan en **tiempo real** mientras escribes
5. Cada resultado muestra:
   - Póster de la película
   - Título y fecha de estreno
   - Calificación promedio de TMDB
   - Sinopsis breve
   - Botón para agregar a favoritos

#### Gestionar Favoritos
1. **Acceso**: Solo usuarios autenticados
2. Navega a **"Mis Favoritos"** en la barra de navegación
3. Desde la búsqueda, haz clic en **"★ Agregar a Favoritos"** en cualquier película
4. La película se guarda con toda su información de TMDB
5. En tu lista de favoritos puedes:
   - Ver todas tus películas guardadas
   - Ver detalles completos (póster, sinopsis, calificación)
   - Eliminar películas con el botón **"Eliminar"**

**Características:**
- ✅ Búsqueda en tiempo real (sin recargar página)
- ✅ Datos actualizados desde TMDB
- ✅ Prevención de duplicados (no puedes agregar la misma película dos veces)
- ✅ Interfaz visual con pósters y calificaciones
- ✅ Favoritos privados por usuario

## 🔑 Permisos del Sistema

### Estructura de Permisos
Los permisos siguen el formato `Módulo.Acción`:

| Módulo | Acciones Disponibles |
|--------|---------------------|
| **Blogs** | `showBlogs`, `createBlogs`, `updateBlogs`, `deleteBlogs` |
| **Secciones** | `showSections`, `createSections`, `updateSections`, `deleteSections` |
| **Usuarios** | `showUsers`, `createUsers`, `updateUsers` |
| **Roles** | `showRoles`, `createRoles`, `updateRoles`, `deleteRoles` |

### Asignación por Rol

| Permiso | Admin | Editor | Visitante |
|---------|-------|--------|-----------|
| Ver Blogs | ✅ | ✅ | ❌ |
| Crear Blogs | ✅ | ✅ | ❌ |
| Editar Blogs | ✅ | ✅ (solo suyos) | ❌ |
| Eliminar Blogs | ✅ | ❌ | ❌ |
| Gestionar Usuarios | ✅ | ❌ | ❌ |
| Gestionar Roles | ✅ | ❌ | ❌ |

### Permisos de Funcionalidades Públicas y Nuevas

| Funcionalidad | Requiere Autenticación | Permisos Especiales | Notas |
|---------------|------------------------|---------------------|-------|
| **Ver Blogs Públicos** | ❌ No | Ninguno | Cualquiera puede ver blogs publicados |
| **Comentar en Blogs** | ❌ No | Ninguno | Usuarios autenticados y visitantes pueden comentar. Visitantes deben proporcionar nombre y email |
| **Buscar Películas** | ✅ Sí | Ninguno | Disponible para todos los usuarios autenticados (Admin, Editor, Visitante) |
| **Agregar a Favoritos** | ✅ Sí | Ninguno | Disponible para todos los usuarios autenticados. Cada usuario gestiona sus propios favoritos |
| **Ver Mis Favoritos** | ✅ Sí | Ninguno | Solo puedes ver tus propios favoritos, no los de otros usuarios |
| **Eliminar de Favoritos** | ✅ Sí | Ninguno | Solo puedes eliminar tus propias películas favoritas |

---

## 🐛 Solución de Problemas

### Error: "Base table or view not found"
```bash
php artisan migrate:fresh --seed
```

### Error: "Class 'App\Helpers\RoleHelper' not found"
```bash
composer dump-autoload
```

### Assets no se actualizan correctamente
```bash
# Detener npm run dev y ejecutar:
npm run build
php artisan cache:clear
```

### Error de permisos en TMDB
Verifica que tu `TMDB_API_KEY` en `.env` sea válida

## 📝 Tareas Pendientes / Roadmap

- [x] Sistema de comentarios en blogs
- [x] Búsqueda y filtros avanzados
- [x] Listas de películas (Watchlist/Favoritos)
- [ ] Sistema de "Me gusta" en comentarios
- [ ] Dashboard de estadísticas para editores
- [ ] Notificaciones de nuevos comentarios
- [ ] Moderación de comentarios

## 👨‍💻 Autor

**Ardila424**
- GitHub: [@Ardila424](https://github.com/Ardila424)
- Proyecto: [Movies Forum Laravel](https://github.com/Ardila424/MoviesForum-Laravel)

<div align="center">

</div>
