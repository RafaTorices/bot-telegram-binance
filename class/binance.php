<?php

class Binance
{
    private $api;
    private $precios;
    private $apiKey;
    private $secretKey;
    private $apiTelegram;
    private $config;
    private $tituloApp;

    public function __construct()
    {
        $bitcoin = new Bitcoin();
        $this->apiKey = $bitcoin::APIKEY;
        $this->secretKey = $bitcoin::SECRETKEY;
        $api = new Binance\API($this->apiKey, $this->secretKey);
        $this->api = $api;
        $apiTelegram = new ApiTelegram();
        $this->apiTelegram = $apiTelegram;
        $config = new AppConfig();
        $this->config = $config;
        $this->tituloApp = $this->config::TITULO_APP;
    }

    public function enviarPrecios($simbolo)
    {
        //Método para obtener los prices
        $simbolo = strtoupper($simbolo);
        $this->precios = $this->api->prices();
        $precio = $this->precios[$simbolo];
        if ($precio != '') {
            $precio = $this->tituloApp . "PRECIO ACTUAL DE <b>" . $simbolo . "</b> = " . $precio;
            return $precio;
        }
    }
}