<?php
//Incluímos las clases
include_once "config/config.php";
include_once "class/mysql.php";
include_once "class/mensaje.php";
include_once "class/api.php";
include_once "class/service.php";
include_once "class/respuestas.php";
include_once "class/opciones.php";
include_once "class/start.php";
include_once "class/usuarios.php";
include_once "class/servicio.php";
include_once "class/binance.php";
include_once 'vendor/autoload.php';

//Ejecutamos la aplicacion llamando a la clase principal
new AppService();