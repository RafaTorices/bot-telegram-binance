<?php
//Clase con toda la lógica de los usuarios
class Usuario
{

    private $apiTelegram;
    private $mysql;
    private $start;
    private $tituloApp;
    private $appConfig;
    private $chatIdSoporteApp;

    public function __construct()
    {
        $apiTelegram = new ApiTelegram();
        $this->apiTelegram = $apiTelegram;
        $mysql = new MySQL();
        $this->mysql = $mysql;
        $start = new Start();
        $this->start = $start;
        $appConfig = new AppConfig();
        $this->appConfig = $appConfig;
        $this->tituloApp = $appConfig::TITULO_APP;
        $this->chatIdSoporteApp = $appConfig::CHAT_ID_SOPORTE_APP;
    }

    //Método que guarda en la BD MySQL el nuevo usuario
    public function guardarUsuario($chatId, $name)
    {
        //Insertamos el usuario en la Base de Datos
        mysqli_query($this->mysql->conexionMySQL, "INSERT INTO usuarios (chatid, name) VALUES ('$chatId', '$name')");
        //Comprobamos el insert si se ha realizado correctamente
        $resultado = mysqli_affected_rows($this->mysql->conexionMySQL);
        if ($resultado == 1) {
            //Le damos bienvenida al usuario
            $this->start->enviarBienvenida($chatId, $name);
            //Avisamos a soporte técnico de un alta nuevo
            $mensaje = $this->tituloApp . "NUEVO USUARIO EN EL BOT: <b>" . $name . " - " . $chatId . "</b>";
            $this->apiTelegram->enviarMensaje($this->chatIdSoporteApp, $mensaje);
        } else {
            //Si el insert no se produce le avisamos
            $mensaje = $this->tituloApp . " <b>" . $name . ",</b> ha ocurrido un error en su inicio en nuestro sistema y por tanto no podrá usar nuestro servicio correctamente. Por favor, utilice las opciones de Telegram para detener el Bot e iniciar de nuevo nuestra aplicación. También puede hacer click aquí /START. Si el problema persiste, contacte con nuestro Soporte Técnico.";
            $this->apiTelegram->enviarMensaje($chatId, $mensaje);
        }
    }

    //Método para comprobar si es usuario
    public function comprobarUsuario($chatId)
    {
        //Consultamos en MySQL si es usuario del sistema
        $sql = mysqli_query($this->mysql->conexionMySQL, "SELECT id FROM usuarios WHERE chatid = '$chatId'");
        $resultado = mysqli_num_rows($sql);
        return $resultado;
    }
}