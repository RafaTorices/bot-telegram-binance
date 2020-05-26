<?php
class Servicio
{

    private $mysql;
    private $apiTelegram;
    private $appConfig;
    private $tituloApp;
    private $chatIdSoporteApp;

    public function __construct()
    {
        $mysql = new MySQL();
        $this->mysql = $mysql;
        $appConfig = new AppConfig();
        $this->appConfig = $appConfig;
        $this->tituloApp = $appConfig::TITULO_APP;
        $this->chatIdSoporteApp = $appConfig::CHAT_ID_SOPORTE_APP;
        $apiTelegram = new ApiTelegram();
        $this->apiTelegram = $apiTelegram;
    }

    public function activarServicio()
    {
        $sql = mysqli_query($this->mysql->conexionMySQL, "SELECT estado FROM servicio WHERE id = 1");
        while ($row = mysqli_fetch_array($sql)) {
            $estado = $row["estado"];
        }
        if ($estado == 0) {
            mysqli_query($this->mysql->conexionMySQL, "UPDATE servicio SET estado = 1 WHERE id = 1");
            $resultado = mysqli_affected_rows($this->mysql->conexionMySQL);
            if ($resultado == 1) {
                return 1;
            } else {
                return 0;
            }
        } else {
            $mensaje = $this->tituloApp . " EL SERVICIO YA ESTA ACTIVADO, NO SE PUEDE VOLVER A ACTIVAR.";
            $this->apiTelegram->enviarMensaje($this->chatIdSoporteApp, $mensaje);
        }
    }

    public function desactivarServicio()
    {
        $sql = mysqli_query($this->mysql->conexionMySQL, "SELECT estado FROM servicio WHERE id = 1");
        while ($row = mysqli_fetch_array($sql)) {
            $estado = $row["estado"];
        }
        if ($estado == 1) {
            mysqli_query($this->mysql->conexionMySQL, "UPDATE servicio SET estado = 0 WHERE id = 1");
            if (mysqli_affected_rows($this->mysql->conexionMySQL) == 1) {
                return 1;
            } else {
                return 0;
            }
        } else {
            $mensaje = $this->tituloApp . " EL SERVICIO YA ESTA DESACTIVADO, NO SE PUEDE VOLVER A DESACTIVAR.";
            $this->apiTelegram->enviarMensaje($this->chatIdSoporteApp, $mensaje);
        }
    }

    public function comprobarServicio()
    {
        $sql = mysqli_query($this->mysql->conexionMySQL, "SELECT estado FROM servicio WHERE id = 1");
        while ($row = mysqli_fetch_array($sql)) {
            $estado = $row["estado"];
        }
        return $estado;
    }

    public function fueraServicio($chatId, $mensaje)
    {
        $mensaje = $this->tituloApp . " <i>EL SISTEMA ESTÁ FUERA DE SERVICIO POR TAREAS DE MANTENIMIENTO/ACTUALIZACIÓN EN ESTOS MOMENTOS. INTÉNTELO PASADOS UNOS MINUTOS. DISCULPE LAS MOLESTIAS.</i>";
        $this->apiTelegram->enviarMensaje($chatId, $mensaje);
    }
}