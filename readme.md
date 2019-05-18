
# HackmeUp 2019
Este es un pequeno ejemplo de un sistema de buscador  de (Trenes, Hoteles), en la documentacion podras encontrar la forma correcta de consumar este api, debemos recordar que esto se realizo en cuestion de horas y por lo tanto muchas cosas no funcionan de la forma que se quiere. Por otra parte se comento en los contraladores los puntos que creemos que se deben de mejorar o optimizar.

# !Importante
Recuerda el archivo .env.example remplazarlo a .env y colocar la conexion a tu BD.

# Documentacion
https://documenter.getpostman.com/view/2056697/S1M3uQfX?version=latest

# Run
`git clone https://github.com/leifermendez/api-hackmeup`

`cd api-hackmeup`

`composer install`

`php artisan key:generate`

`php artisan migrate`

`php artisan db:seed`

`php artisan serve`

Luego de correr estos comando en orden, ya deberias poder ingresa a tu navegador
`http://127.0.0.1:8000`

Front (Angular) https://github.com/yond1994/hackmeup
El autor del front yond1994@gmail.com

Contacto leifer33@gmail.com