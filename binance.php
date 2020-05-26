<?php
require 'vendor/autoload.php';
// Config by specifying api key and secret
$api = new Binance\API("qSAK2Z7xZOO8OX0c3w5X9WiowFOt5y5TAJZINMXJXQsBEePRtyDdPO46SV3ZWv3e", "tiGvwup4t8tzj5IbxXkCTWrWh6c1DhjMESvjOTRd5FFbUHceuAsFYfkNYNt1styx");

//Método para obtener los prices
$precios = $api->prices();
$BNBBTC = "BNBBTC";
$precio = $api->price($BNBBTC);
echo $precio;