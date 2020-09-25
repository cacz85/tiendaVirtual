<?php

class AdmonUsuarios extends Controlador {
    private $modelo;

    function __construct() {
        $this->modelo = $this->modelo("AdmonUsuariosModelo");
    }

    public function caratula() {
        // Crear sesión
        $sesion = new Sesion();

        if ($sesion->getLogin()) {
            // Leer los datos de la tabla (MySQL)
            $data = $this->modelo->getUsuarios();
            // print "<pre>";
            // var_dump($data);
            // print "</pre>";

            $datos = [
                "titulo" => "Administrativo Usuarios",
                "menu" => false,
                "admon" => true,
                "data" => $data
            ];
            $this->vista("admonUsuariosCaratulaVista", $datos);
        } else {
            header("location:".RUTA."admon");
        }        
    }

    public function alta() {
        if ($_SERVER['REQUEST_METHOD']=="POST") {
            $errores = array();
            $data = array();

            $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
            $clave1 = isset($_POST["clave1"]) ? $_POST["clave1"] : "";
            $clave2 = isset($_POST["clave2"]) ? $_POST["clave2"] : "";
            $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
            
            // Validación
            if (empty($usuario)) {
                array_push($errores, "El usuario es requerido");
            }
            if (empty($clave1)) {
                array_push($errores, "La clave de acceso es requerida");
            }
            if (empty($clave2)) {
                array_push($errores, "La verificación de la clave de acceso es requerida");
            }
            if ($clave1!=$clave2) {
                array_push($errores, "Las claves no coinciden, favor de verificar");
            }
            if (empty($nombre)) {
                array_push($errores, "El nombre del usuario es requerido");
            }
            // Arreglo de datos
            $data = [
                "nombre" => $nombre,
                "clave1" => $clave1,
                "clave2" => $clave2,
                "usuario" => $usuario
            ];

            // Verificamos que no haya errores
            if (empty($errores)) {
                if ($this->modelo->insertarDatos($data)) {
                    header("location:".RUTA."admonUsuarios");
                } else {
                    $datos = [
                        "titulo" => "Error en el registro",
                        "menu" => false,
                        "errores" => [],
                        "data" => [],
                        "subtitulo" => "Error en la inserción del registro",
                        "texto" => "Existió un error al insertar el registro, favor de intentarlo mas tarde o comunicarse a soporte técnico",
                        "color" => "alert-danger",
                        "url" => "admonInicio",
                        "colorBoton" => "btn-danger",
                        "textoBoton" => "Regresar"
                        ];
                        $this->vista("mensajeVista",$datos);
                }
            } else {
                $datos = [
                    "titulo" => "Administrativo Usuarios Alta",
                    "menu" => false,
                    "admon" => true,
                    "errores" => $errores,
                    "data" => $data
                ];
                $this->vista("admonUsuariosVista", $datos);
            }            
        } else {
            $datos = [
                "titulo" => "Administrativo Usuarios Alta",
                "menu" => false,
                "admon" => true,
                "data" => []
            ];
            $this->vista("admonUsuariosVista", $datos);
        }
    }

    public function baja($id="") {
        // Definiendo Arreglos
        $errores = array();
        $data = array();
        
        // Recibiendo de la vista
        if ($_SERVER['REQUEST_METHOD']=="POST") { 
            $id = isset($_POST["id"]) ? $_POST["id"] : "";
            if (!empty($id)) {
                $errores = $this->modelo->bajaLogica($id);
                // Si no hay errores se regresa a la pagina admonUsuariosCaratulaVista
                if (empty($errores)) {
                    header("location:".RUTA."admonUsuarios");
                }
            }
        }

        $data = $this->modelo->getUsuarioId($id);
        $llaves = $this->modelo->getLlaves("admonStatus");

        // Abrir Vista
        $datos = [
            "titulo" => "Administrativo Usuarios Baja",
            "menu" => false,
            "admon" => true,
            "status" => $llaves,
            "errores" => $errores,
            "data" => $data
        ];
        $this->vista("admonUsuariosBorrarVista", $datos);
    }

    public function cambio($id="") {
        // Definiendo Arreglos
        $errores = array();
        $data = array();
        
        // Recibiendo de la vista
        if ($_SERVER['REQUEST_METHOD']=="POST") {
            // Limpiando variables
            $id = isset($_POST["id"]) ? $_POST["id"] : "";
            $correo = isset($_POST["correo"]) ? $_POST["correo"] : "";
            $clave1 = isset($_POST["clave1"]) ? $_POST["clave1"] : "";
            $clave2 = isset($_POST["clave2"]) ? $_POST["clave2"] : "";
            $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
            $status = isset($_POST["status"]) ? $_POST["status"] : "";
            
            // Validación
            if (empty($correo)) {
                array_push($errores, "El usuario es requerido");
            }
            if (empty($nombre)) {
                array_push($errores, "El nombre del usuario es requerido");
            }
            if ($status == "void") {
                array_push($errores, "Selecciona el status del usuario por favor");
            }
            if (!empty($clave1) && !empty($clave2)) {
                if ($clave1 != $clave2) {
                    array_push($errores, "Las claves de acceso no coinciden");
                }
            }
            if (empty($errores)) {                
                // Arreglo de datos
                $data = [
                    "id" => $id,
                    "nombre" => $nombre,
                    "clave1" => $clave1,
                    "clave2" => $clave2,
                    "status" => $status,
                    "correo" => $correo
                ];
                // Enviar al modelo
                $errores = $this->modelo->modificarUsuario($data);
                
                // Validar la modificación
                if (empty($errores)) {
                    header("location:".RUTA."admonUsuarios");
                }
            }
        } 

        $data = $this->modelo->getUsuarioId($id);
        $llaves = $this->modelo->getLlaves("admonStatus");

        $datos = [
            "titulo" => "Administrativo Usuarios Modificar",
            "menu" => false,
            "admon" => true,
            "status"=> $llaves,
            "errores" => $errores,
            "data" => $data
        ];
        $this->vista("admonUsuariosModificaVista", $datos);
    }
}

