<?php
//Clase para conectar con MySQL
class MySQL
{
    //Declaramos las variables de conexion
    public $conexionMySQL;
    private $host;
    private $user;
    private $password;
    private $database;

    public function __construct()
    {
        //Inicializamos las variables de conexion
        $mySqlConfig = new MySQLConfig();
        $this->host = $mySqlConfig::DB_HOST;
        $this->user = $mySqlConfig::DB_USER;
        $this->password = $mySqlConfig::DB_PASSWORD;
        $this->database = $mySqlConfig::DB_NAME;
        //Almacenamos la conexion en un metodo
        $this->conexionMySQL = mysqli_connect($this->host, $this->user, $this->password, $this->database);
    }
}