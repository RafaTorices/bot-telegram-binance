<?php

class Binance
{
    private $api;
    private $precios;
    private $apiKey;
    private $secretKey;

    public function __construct()
    {
        $bitcoin = new Bitcoin();
        $this->apiKey = $bitcoin::APIKEY;
        $this->secretKey = $bitcoin::SECRETKEY;
        $api = new Binance\API($this->apiKey, $this->secretKey);
        $this->api = $api;
    }

    // public function enviarPreciosIndividual()
    // {
    //     //Método para obtener los prices
    //     $this->precios = $this->api->prices();
    //     $simbolo = "BNBBTC";
    //     $this->precio = $this->api->price($simbolo);
    //     return $this->precio;
    // }

    public function enviarPrecios()
    {
        //Método para obtener los prices
        //$this->precios = $this->api->prices();
        //$simbolo = "BNBBTC";
        $this->precio = $this->api->prices();
        foreach ($this->precio as $precio) {
            return $precio;
        }
    }
}