<?php

class Respuesta
{
    //Declaramos las variables
    private $apiTelegram;
    private $opciones;
    private $start;
    private $usuario;
    private $appConfig;
    private $tituloApp;
    private $mensaje;
    private $servicio;

    //Inicializamos el sistema y obtenemos todos los mensajes que entren al servicio
    public function __construct()
    {
        //Instanciamos la clase de ApiTelegram
        $apiTelegram = new ApiTelegram();
        $this->apiTelegram = $apiTelegram;
        $appConfig = new AppConfig();
        $this->appConfig = $appConfig;
        $this->chatIdSoporteApp = $appConfig::CHAT_ID_SOPORTE_APP;
        $this->tituloApp = $appConfig::TITULO_APP;
        $opciones = new Opciones();
        $this->opciones = $opciones;
        $start = new Start();
        $this->start = $start;
        $usuario = new Usuario();
        $this->usuario = $usuario;
        $mensaje = new Mensaje();
        $this->mensaje = $mensaje;
        $servicio = new Servicio();
        $this->servicio = $servicio;
    }

    //Método que enviará la respuesta dependiendo del mensaje obtenido
    public function enviarRespuesta($chatId, $mensaje, $name)
    {
        switch ($mensaje) {
            case "/status":
                if ($chatId == $this->chatIdSoporteApp) {
                    return $this->apiTelegram->getWebhookInfo($chatId);
                    break;
                }
                return $this->apiTelegram->enviarMensajeNoEntiendo($chatId, $mensaje, $name);
                break;
            case "/opciones":
                return $this->opciones->enviarOpciones($chatId, $mensaje);
                break;
            case "/start":
                if ($this->usuario->comprobarUsuario($chatId) == 0) {
                    $this->usuario->guardarUsuario($chatId, $name);
                    $this->opciones->enviarOpciones($chatId, $mensaje);
                    break;
                } else {
                    return $this->apiTelegram->enviarMensajeNoEntiendo($chatId, $mensaje, $name);
                    break;
                }
            case "activar-servicio":
                if ($chatId == $this->chatIdSoporteApp) {
                    if ($this->servicio->activarServicio() == 1) {
                        $mensaje = $this->tituloApp . " SISTEMA <b>ACTIVADO</b> CORRECTAMENTE";
                        $this->apiTelegram->enviarMensaje($chatId, $mensaje);
                        break;
                    } else {
                        $mensaje = $this->tituloApp . " HA OCURRIDO UN ERROR AL <b>ACTIVAR</b> EL SERVICIO. INTÉNTELO PASADOS UNOS MINUTOS. COMPRUEBE EL SISTEMA.";
                        $this->apiTelegram->enviarMensaje($chatId, $mensaje);
                        break;
                    }
                } else {
                    return $this->apiTelegram->enviarMensajeNoEntiendo($chatId, $mensaje, $name);
                    break;
                }
            case "desactivar-servicio":
                if ($chatId == $this->chatIdSoporteApp) {
                    if ($this->servicio->desactivarServicio() == 1) {
                        $mensaje = $this->tituloApp . " SISTEMA <b>DESACTIVADO</b> CORRECTAMENTE";
                        $this->apiTelegram->enviarMensaje($chatId, $mensaje);
                        break;
                    } else {
                        $mensaje = $this->tituloApp . " HA OCURRIDO UN ERROR AL <b>DESACTIVAR</b> EL SERVICIO. INTÉNTELO PASADOS UNOS MINUTOS. COMPRUEBE EL SISTEMA.";
                        $this->apiTelegram->enviarMensaje($chatId, $mensaje);
                        break;
                    }
                } else {
                    return $this->apiTelegram->enviarMensajeNoEntiendo($chatId, $mensaje, $name);
                    break;
                }
            case "estado-servicio":
                if ($chatId == $this->chatIdSoporteApp) {
                    if ($this->servicio->comprobarServicio() == 1) {
                        $mensaje = $this->tituloApp . " ESTADO DEL SISTEMA: <b>ACTIVADO</b>";
                        $this->apiTelegram->enviarMensaje($chatId, $mensaje);
                        break;
                    } else {
                        $mensaje = $this->tituloApp . " ESTADO DEL SISTEMA: <b>DESACTIVADO</b>";
                        $this->apiTelegram->enviarMensaje($chatId, $mensaje);
                        break;
                    }
                } else {
                    return $this->apiTelegram->enviarMensajeNoEntiendo($chatId, $mensaje, $name);
                    break;
                }

                //Por defecto sino se envia esto...
            default:
                return $this->apiTelegram->enviarMensajeNoEntiendo($chatId, $mensaje, $name);
                break;
        }
    }
}