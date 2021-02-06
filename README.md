<p align="center">
    <img src="public/img/temple-repositorios.jpg">
</p>

# Rocket System v.1 Beta

## Antes de comenzar

### Ejecutar el siguiente comando en la terminal para actualizar los repositorio de laravel con composer: 
    $ composer update

### Configurar la base de datos en el archivo .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1  // Host por defecto
DB_PORT=3306       // Puerto por defecto
DB_DATABASE="Nombre de la base de datos"
DB_USERNAME="Usuario de la base de datos"
DB_PASSWORD="Contraseña de no tener dejar vacio"
```

### Generar las llaves correspondientes al proyecto ejecutando:
    $ php artisan key:generate
### Crear las migraciones y los seeder a la base de datos de Mysql:
    $ php artisan migrate:refresh --seed
