<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Entorno de desarrollo
- Herramientas necesarias ``composer 2.8^, php 8.4, mysql 8.4``.

## Pasos de instalación

#### Importante tener creada la base de datos previamente

1. Clonar el repositorio de [backend](https://github.com/DanielZC/backend.git)
2. Copiar el archivo ``.env.example`` y cambiarle el nombre a ``.env``
3. Reemplazar las variables del archivo original por tus datos de conexión
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5433
DB_DATABASE=itbf
DB_USERNAME=postgres
DB_PASSWORD=123456
```
4. Ejecutar el comando `composer install` dentro de la carpeta del proyecto
5. Ejecutar las migraciones: `php artisan migrate` esto ejecutará las migraciones del proyecto y un seeder para crear un usuario por defecto para pruebas rápidas
6. Ejecutar el comando `php artisan serve` la API se expone en localhost:8000/

## Pasos de instalación para subir base de datos (Railway)

1. Crear una cuenta en [Railway](https://railway.com) e iniciar sesión
2. Crear un nuevo proyecto usando el botón "New +"
3. Luego de crear el proyecto y acceder a él, hacer clic derecho y seleccionar la opción "Database", luego elegir "PostgreSQL" y se creará el servicio automáticamente
4. Una vez creado, hacer clic izquierdo sobre el servicio y se abrirá un panel. Seleccionar la opción "Variables" para conectarse al servicio; solo debemos usar los valores de las variables

> **Importante:** Para obtener el host, debemos ir a la opción "Settings" y buscar la sección **Networking > Public Networking**. Copiar la dirección sin el puerto `:5432`.  
> **Ejemplo:** Si la dirección es `turntable.proxy.rlwy.net:53377`, usamos `53377` como puerto la conectar con la base de datos.

```bash
PGPASSWORD
PGUSER
PGDATABASE
```
5. Conectar al servicio de PostgreSQL haciendo uso de las variables anteriores
6. Luego de hacer la conexión, seleccionar la base de datos y ejecutar el archivo `itbf.sql` para crear las tablas

## Pasos para despliegue (Railway) usando imagen de Docker

1. Subir el proyecto a GitHub
2. Tener una cuenta creada en [Railway](https://railway.com) y vinculada con la cuenta de [GitHub](https://github.com)
3. Hacer clic derecho en el proyecto creado anteriormente, seleccionar "GitHub Repo" y luego elegir el proyecto

> **Importante:** Esta configuración es necesaria para el despliegue correcto del proyecto.

### Configuración de build en Railway

1. Hacer clic izquierdo en "Settings" del servicio backend recién creado, ir a la sección "Build" y cambiar el valor de "Railpack" a "Dockerfile". Luego, justo debajo, en "Dockerpath", usar la opción `/Dockerfile`

### Configuración de variables de entorno en Railway

1. Hacer clic izquierdo en "Variables" y luego en el botón "Raw Editor". Copiar todas las variables del archivo `.env` con todas las configuraciones necesarias. Las más importantes son las de base de datos (DB) del `.env` del proyecto

**Ejemplo:**
```bash
DB_CONNECTION=pgsql
DB_HOST=turntable.proxy.rlwy.net
DB_PORT=53377
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=idxjSCmQPTzNeqiCYb
DB_SSLMODE=require
```
Después de haber terminado con todo lo anterior, se habilitará un botón para hacer el "Deploy" del proyecto

## Problemas durante el despliegue

### Backend
- Problema de compatibilidad entre la versión de PHP del proyecto (PHP 8.4) y la versión de PHP que usa Railway para el build de la aplicación.
  - **Solución:** Crear un archivo `Dockerfile` con una imagen de PHP configurada con la versión 8.4 compatible con el proyecto. Por eso se realizó la configuración de build antes mencionada en las instrucciones de despliegue de Railway.

### Frontend
- Problema con las importaciones del proyecto. Al correr Vercel en Linux, tiene sensibilidad por las mayúsculas y minúsculas, lo que puede generar errores al tener importaciones como: `Archivo.css` → `import ../archivo.css`.
  - **Solución:** Asegurarse de que todas las importaciones coincidan exactamente con los nombres de los archivos.

