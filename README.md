<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Entorno de desarrollo
- Herramientas necesarias ``composer 2.8^, php 8.4, mysql 8.4``.

## Pasos de instalación

#### Importante tener creada la base de datos previamente

1. Clonar el repositorio de [https://github.com/DanielZC/auth.git](https://github.com/DanielZC/backend.git)
2. Copiar el archivo .env.example y cambiarle el nombre a .env
3. Reemplazar las variables del archivo original por estas
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
