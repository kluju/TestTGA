# Prueba  TGA


> **¡IMPORTANTE!**
>Se debe tener npm, composer  y node

## Configurar BACKEND
>

## Puntos a realizar
* crear BD mySql `encuestas`.
* entrar a la carpeta  `backend`.
* Editar el archivo `.env` y para cambiar la configuracion de la BD
	 Implementación .
	 		# Database
			DB_HOST=127.0.0.1
			DB_PORT=3306
			DB_DATABASE=encuestas
			DB_USERNAME=root
			DB_PASSWORD=
* luego ejecutar `composer install` en la consola dentro de `backend`.
* luego ejecutar : `php artisan migrate` para las migraciones.
* luego ejecutar Semillas :  `php artisan db:seed --class=PreguntaSeeder` `php artisan db:seed --class=AlternativaSeeder`.
* y para finalizar ejecutar el servidor  `php artisan serve --host=127.0.0.2 --port=8080` asi lo hago de forma local

## Recomendaciones
* tener instalado composer .

## Configurar FRONTEND

## Puntos a realizar
* entrar a la carpeta  `frontend` desde la raiz de proyecto.
* ditar el archivo  `.env` para cambiar la configuracion de las urls de la `API`.
* luego ejecutar : `npm install` y `npm start` en la consola dentro de `frontend`.
