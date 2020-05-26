<?php

//Clase Opciones que contiene los datos y métodos de las opciones del servicio
class Opciones
{
    private $apiTelegram;
    private $appConfig;
    private $tituloApp;
    private $telefonoApp;
    private $mysql;

    public function __construct()
    {
        $apiTelegram = new ApiTelegram();
        $this->apiTelegram = $apiTelegram;
        $appConfig = new AppConfig();
        $this->appConfig = $appConfig;
        $this->tituloApp = $appConfig::TITULO_APP;
        $this->telefonoApp = $appConfig::TELEFONO_SOPORTE_APP;
        $this->chatIdApp = $appConfig::CHAT_ID_SOPORTE_APP;
        $mysql = new MySQL();
        $this->mysql = $mysql;
    }

    function enviarOpciones($chatId, $mensaje)
    {
        //Ejemplo de array
        //$opciones = mysqli_fetch_all($sql);
        //$opciones = [['1', '2', '3', '4'], ['1', '2']];
        $opciones = [['/PRECIOS', '/AYUDA']];
        //Defino la botonera de opciones y se lo envio al usuario
        $keyboard = array(
            //Opciones almacenadas en el array multidimensional
            "keyboard" => $opciones,
            //Al pulsar una opcion, las opciones desaparecen
            "one_time_keyboard" => true,
            "remove_keyboard" => true,
            //Los botones se autoredefinen para ser visibles
            "resize_keyboard" => true,
        );
        //Defino el mensaje que será enviado al usuario generando una URL con el metodo http_build_query
        $botonera = http_build_query(array(
            //Usuario destinatario del mensaje
            'chat_id' => $chatId,
            //Texto del mensaje que le aparecerá al usuario
            'text' => $this->tituloApp . "/OPCIONES",
            //Texto parseado en HTML
            'parse_mode' => "HTML",
            //Se convierte en formato json el array de las opciones
            'reply_markup' => json_encode($keyboard),
        ));
        //Llamamos al método de enviar el mensaje
        return $this->apiTelegram->enviarBotones($botonera);
    }
}