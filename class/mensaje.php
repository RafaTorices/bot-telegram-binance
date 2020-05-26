<?php

class Mensaje
{
    private $mysql;
    public function __construct()
    {
        $mysql = new MySQL();
        $this->mysql = $mysql;
    }

    public function guardarMensaje($chatId, $mensaje, $name)
    {
        mysqli_query($this->mysql->conexionMySQL, "INSERT INTO mensajes (chat_id, mensaje, name) VALUES ('$chatId', '$mensaje', '$name')");
    }
}