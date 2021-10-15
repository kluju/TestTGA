# PruebaDataQuFinal
Configuracion Backend

crear BD mySql arriendo_de_autos

entrar a la carpeta backend

Editar el archivo .env para cambiar la configuracion de la BD
	# Database
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=arriendo_de_autos
	DB_USERNAME=root
	DB_PASSWORD=

 
luego ejecutar composer install

luego ejecutar : "php artisan migrate" para las migraciones 

luego ejecutar Semillas :
	php artisan db:seed --class=ClienteSeeder
	php artisan db:seed --class=EmpresaSeeder
	php artisan db:seed --class=ArriendoSeeder

y para finalizar ejecutar el servidor "php artisan serve --host=127.0.0.2 --port=8080"


Configuracion FrontEnd

entrar a la carpeta frontend
ditar el archivo .env para cambiar la configuracion de la urls de la API

por consola ejecutar npm install y luego npm start
