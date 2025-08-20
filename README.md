# 🌱 Chacharitas - Plataforma de Comercio Sustentable

<div align="center">
  <img src="public/img/logo.png" alt="Chacharitas Logo" width="150">
  
  [![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
  [![Laravel](https://img.shields.io/badge/Laravel-11.9-red.svg)](https://laravel.com)
  [![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
  [![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](contributing.md)
</div>

## 📖 Descripción del Proyecto

**Chacharitas** es una plataforma web innovadora diseñada para padres mexicanos que buscan comprar y vender ropa para niños y bebés de segunda mano. Nuestro objetivo es combinar **economía circular** con **tecnología moderna** para reducir la contaminación textil y apoyar la economía familiar.

### 🎯 Problema que Resuelve

-   **Sostenibilidad**: Solo el 15% de los residuos textiles se reciclan actualmente
-   **Economía**: Los niños crecen rápidamente, generando gastos constantes en ropa
-   **Calidad**: Ropa infantil de calidad que puede tener una segunda vida útil

### 💡 Propuesta de Valor

-   ✅ **Marketplace especializado** en ropa infantil de segunda mano
-   ✅ **Sistema de verificación de usuarios** con email authentication
-   ✅ **Panel de administración** robusto para gestión del negocio
-   ✅ **Diseño responsive** optimizado para dispositivos móviles

## 🛠️ Stack Tecnológico

### Backend

-   **[Laravel 11.9](https://laravel.com/)** - Framework PHP moderno con arquitectura MVC
-   **[PHP 8.2+](https://php.net)** - Lenguaje de programación principal
-   **[MySQL](https://mysql.com)** - Base de datos relacional
-   **[Laravel Fortify](https://laravel.com/docs/fortify)** - Autenticación y verificación de email
-   **[Livewire](https://laravel-livewire.com/)** - Componentes dinámicos full-stack
-   **[Spatie Laravel Permission](https://spatie.be/docs/laravel-permission/)** - Sistema de roles y permisos

### Frontend

-   **[Tailwind CSS 3.4](https://tailwindcss.com/)** - Framework CSS utility-first
-   **[DaisyUI 4.12](https://daisyui.com/)** - Biblioteca de componentes para Tailwind
-   **[Vite 5.0](https://vitejs.dev/)** - Build tool y bundler moderno

### Panel de Administración

-   **[Filament 3.2](https://filamentphp.com/)** - Panel de administración completo con:
    -   CRUD automático para modelos
    -   Dashboard con widgets personalizados

### Servicios Externos

-   **[Mailgun](https://mailgun.com)** - Servicio de emails transaccionales
-   **[Google Maps API](https://developers.google.com/maps)** - Geolocalización y mapas

### DevOps

-   **[GitHub Actions](https://github.com/features/actions)** - CI/CD pipeline
-   **Docker** - Containerización para desarrollo y producción

## 🚀 Funcionalidades Principales

### Para Usuarios

-   👤 **Registro y autenticación** con verificación por email
-   🛍️ **Catálogo de productos** con búsqueda y filtros avanzados
-   📱 **Subida de productos** con wizard intuitivo y múltiples imágenes
-   🗺️ **Sistema de ubicación** automático por código postal
-   📧 **Notificaciones** por email y servicio de correos

## 🏗️ Arquitectura del Sistema

### Patrones de Diseño Implementados

-   **MVC (Model-View-Controller)** - Separación clara de responsabilidades
-   **Repository Pattern** - Abstracción de acceso a datos
-   **Service Layer** - Lógica de negocio encapsulada
-   **Observer Pattern** - Para eventos del sistema (emails, notificaciones)
-   **Factory Pattern** - Para creación de objetos complejos

### Estructura del Proyecto

```
chacharitas/
├── app/
│   ├── Actions/Fortify/          # Acciones personalizadas de autenticación
│   ├── Console/Commands/         # Comandos Artisan personalizados
│   ├── Filament/                # Panel de administración
│   ├── Http/Controllers/        # Controladores de la aplicación
│   ├── Livewire/               # Componentes Livewire
│   ├── Mail/                   # Clases de email
│   ├── Models/                 # Modelos Eloquent
│   └── Providers/             # Service Providers
├── database/
│   ├── factories/             # Factories para testing
│   ├── migrations/           # Migraciones de base de datos
│   └── seeders/             # Seeders para datos iniciales
├── resources/
│   ├── css/                 # Estilos Tailwind CSS
│   ├── js/                  # JavaScript y Alpine.js
│   └── views/              # Plantillas Blade
└── tests/                  # Tests automatizados
```

## 📋 Requisitos del Sistema

### Servidor de Producción

-   **PHP**: 8.2 o superior
-   **Composer**: 2.x
-   **Node.js**: 18.x o superior
-   **MySQL**: 8.0 o superior
-   **Nginx/Apache**: Servidor web
-   **SSL**: Certificado para HTTPS

## 🔧 Instalación y Configuración

### 1. Clonar el Repositorio

```bash
git clone https://github.com/Fezto/chacharitas.git
cd chacharitas
```

### 2. Instalar Dependencias

```bash
# Dependencias PHP
composer install

# Dependencias Node.js
npm install
```

### 3. Configuración del Entorno

```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Configurar base de datos en .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chacharitas
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 4. Configurar Servicios Externos

```bash
# Mailgun para emails
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=tu-dominio.mailgun.org
MAILGUN_SECRET=tu_secret_key

# Google Maps
GOOGLE_MAPS_KEY=tu_api_key

# Shippo para envíos
SHIPPO_API_TOKEN=tu_token
```

### 5. Ejecutar Migraciones y Seeders

```bash
php artisan migrate --seed
```

### 6. Compilar Assets

```bash
npm run build
```

### 7. Configurar Permisos

```bash
chmod -R 775 storage bootstrap/cache
```

## 🚀 Deployment

### Deployment Automático

El proyecto incluye un script de deployment automatizado:

```bash
# Hacer el script ejecutable
chmod +x deploy.sh

# Ejecutar deployment
./deploy.sh
```

### GitHub Actions

Pipeline de CI/CD configurado que se activa automáticamente en push a `main`:

-   ✅ Ejecuta tests automatizados
-   ✅ Instala dependencias
-   ✅ Compila assets
-   ✅ Despliega a producción

## 🧪 Testing

```bash
# Ejecutar todos los tests
php artisan test

# Tests con coverage
php artisan test --coverage

# Tests específicos
php artisan test --filter=UserTest
```

### Contribución a la Sostenibilidad

-   **Reducción de residuos textiles**: Extendiendo la vida útil de la ropa infantil
-   **Economía circular**: Promoviendo la reutilización sobre el consumo nuevo
-   **Educación ambiental**: Concientización sobre el impacto del fast fashion

## 👥 Equipo de Desarrollo

**Desarrollador Full-Stack**

-   Diseño y arquitectura del sistema
-   Implementación backend con Laravel
-   Desarrollo frontend con Tailwind CSS
-   Integración de servicios externos
-   DevOps y deployment

## 📞 Contacto y Contribuciones

-   **Email**: chacharitas@gmail.com
-   **Repositorio**: [GitHub](https://github.com/Fezto/chacharitas)
-   **Documentación**: [Wiki del proyecto](https://github.com/Fezto/chacharitas/wiki)

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---

<div align="center">
  <p><strong>🌱 Construyendo un futuro más sustentable, una prenda a la vez</strong></p>
  <p>Hecho con ❤️ en México 🇲🇽</p>
</div>
