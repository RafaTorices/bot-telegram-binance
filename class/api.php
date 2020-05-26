<?php

class ApiTelegram
{
    //Declaramos las variables
    private $urlApp;
    private $tituloApp;
    private $telefonoApp;
    private $chatidApp;
    private $emailApp;
    private $parseMode;

    public function __construct()
    {
        //Instanciamos la clase de Configuración
        $appConfig = new AppConfig();
        $this->urlApp = $appConfig::URL_APP;
        $this->tituloApp = $appConfig::TITULO_APP;
        $this->emailApp = $appConfig::EMAIL_SOPORTE_APP;
        $this->parseMode = $appConfig::PARSE_MODE_APP;
    }

    //Método para enviar mensajes
    public function enviarMensaje($chatId, $mensaje)
    {
        file_get_contents($this->urlApp . "/sendmessage?chat_id=" . $chatId . "&parse_mode=" . $this->parseMode . "&text=" . $mensaje);
    }

    //Método para enviar mensaje de no entiendo
    public function enviarMensajeNoEntiendo($chatId, $mensaje, $name)
    {
        $mensaje = $this->tituloApp . "Lo siento <b>" . $name . "</b>, pero no entiendo su mensaje, use las opciones disponibles (/OPCIONES)";
        file_get_contents($this->urlApp . "/sendmessage?chat_id=" . $chatId . "&parse_mode=" . $this->parseMode . "&text=" . $mensaje);
    }

    //Método para enviar mensaje con array tipo opciones
    public function enviarBotones($botonera)
    {
        file_get_contents($this->urlApp . "/sendmessage?" . $botonera);
    }


    //Método para enviar el status del servicio
    public function getWebhookInfo($chatId)
    {
        //Llamamos al método de la ApiBotTelegram
        $mensaje = json_decode(file_get_contents($this->urlApp . "/getWebhookInfo"), TRUE);
        //Obtenemos los valores de la llamada
        $ok = $mensaje["ok"];
        $pendingUpdateCount = $mensaje["result"]["pending_update_count"];
        $lastErrorMessage = $mensaje["result"]["last_error_message"];
        $lastErrorDate = $mensaje["result"]["last_error_date"];
        //Transformamos la fecha/hora de UNIX a DATETIME
        $lastErrorDate = date("d/m/Y H:i:s", $lastErrorDate);
        //Texto del mensaje que se enviará
        $mensaje = $this->tituloApp . "<i>ESTADO ACTUAL DEL SERVICIO:</i> OK = " . $ok .
            " | PENDING UPDATE COUNT = " . $pendingUpdateCount .
            " | last_error_message = " . $lastErrorMessage . " (" . $lastErrorDate . ")";
        $this->enviarMensaje($chatId, $mensaje);
    }
}