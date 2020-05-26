<?php

//Métodos cuando el usuario hace un /start
class Start
{
    private $apiTelegram;
    private $appConfig;
    private $tituloApp;
    private $telefonoApp;

    public function __construct()
    {
        $apiTelegram = new ApiTelegram();
        $this->apiTelegram = $apiTelegram;
        $appConfig = new AppConfig();
        $this->appConfig = $appConfig;
        $this->tituloApp = $appConfig::TITULO_APP;
        $this->telefonoApp = $appConfig::TELEFONO_SOPORTE_APP;
        $this->chatIdApp = $appConfig::CHAT_ID_SOPORTE_APP;
    }

    //Método para enviarla la bienvenida a un nuevo usuario
    public function enviarBienvenida($chatId, $name)
    {
        $mensaje = "Hola <b>" . $name . "</b>, Bienvenido a nuestro sistema " . $this->tituloApp . " Use las opciones para moverse por la aplicación (/OPCIONES). Consulte /AYUDA para conocer mejor nuestro servicio, /SOPORTE para contactar con Soporte Técnico, /REGISTRO para registrarse en nuestro sistema.";
        return $this->apiTelegram->enviarMensaje($chatId, $mensaje);
    }
}