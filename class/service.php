<?php
class AppService
{
    //Declaramos las variables
    private $respuesta;
    private $mensaje;
    private $request;
    private $token;
    private $tituloApp;
    private $chatIdSoporteApp;
    private $mysql;
    private $apiTelegram;
    private $usuario;
    private $servicio;

    //Inicializamos el sistema y obtenemos todos los mensajes que entren al servicio
    public function __construct()
    {
        //Instanciamos la clase de Respuesta
        $appConfig = new AppConfig();
        $this->token = $appConfig::TOKEN_APP;
        $this->tituloApp = $appConfig::TITULO_APP;
        $this->chatIdSoporteApp = $appConfig::CHAT_ID_SOPORTE_APP;
        $this->checkToken = $this->checkToken();
        $mysql = new MySQL();
        $this->mysql = $mysql;
        $apiTelegram = new ApiTelegram();
        $this->apiTelegram = $apiTelegram;
        $usuario = new Usuario();
        $this->usuario = $usuario;
        $servicio = new Servicio();
        $this->servicio = $servicio;


        if ($this->checkToken()) {
            //Recibimos el mensaje
            $this->request = $this->recibirMensaje();

            //Obtenemos los datos del mensaje
            //El id del remitente
            $chatId = $this->request->message->chat->id;
            //El mensaje del remitente
            $mensaje = $this->request->message->text;
            //Convertimos a minúsculas siempre el mensaje recibido
            $mensaje = strtolower($mensaje);
            $firstName = $this->request->message->chat->first_name;
            $lastName = $this->request->message->chat->last_name;
            $name = $firstName . " " . $lastName;

            //Guardamos el mensaje en la BD
            //$this->mensaje->guardarMensaje($chatId, $mensaje, $name);

            //Comprobamos si el servicio esta activo para enviarle respuesta
            // $estado = $this->servicio->comprobarServicio();
            // if ($estado == 0 && $chatId != $this->chatIdSoporteApp) {
            //     if ($this->usuario->comprobarUsuario($chatId) == 0) {
            //         $this->usuario->guardarUsuario($chatId, $name);
            //         $this->servicio->fueraServicio($chatId, $mensaje);
            //     } else {
            //         $this->servicio->fueraServicio($chatId, $mensaje);
            //     }
            // } else {
            //     //Le respondemos dependiendo de su mensaje
            $this->respuesta->enviarRespuesta($chatId, $mensaje, $name);
            // }
        }
    }

    public function checkToken()
    {
        $pathInfo = ltrim($_SERVER['PATH_INFO'] ?? '', '/');
        return $pathInfo == $this->token;
    }

    public function recibirMensaje()
    {
        //Obteniendo el mensaje en JSON del mensaje recibido en el BOT
        $messageTelegram = file_get_contents("php://input");
        $request = json_decode($messageTelegram);
        //Guardamos el JSON obtenido del mensaje en un fichero json
        $fichero = fopen("mensaje.json", "w+");
        fwrite($fichero, $messageTelegram);
        return $request;
    }
}