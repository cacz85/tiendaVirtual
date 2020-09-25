<?php
/** Modelo AdmonUsuarioModelo */
class AdmonUsuariosModelo {
    private $db;

    function __construct() {
        $this->db = new MySQLdb();
    }

    public function insertarDatos($data) {
        // Clave encriptada
        $clave = hash_hmac("sha512", $data["clave1"], LLAVE);
        $fechaVacia = "0000-00-00 00:00:00";

        $sql = "INSERT INTO admon VALUES(0,";
        $sql .= "'".$data["nombre"]."', ";
        $sql .= "'".$data["usuario"]."', ";
        $sql .= "'".$clave."', ";
        $sql .= "1, "; // Clave
        $sql .= "0, "; // Baja
        $sql .= "'".$fechaVacia."', "; // Fecha del ultimo login
        $sql .= "'".$fechaVacia."', "; // Fecha de la baja
        $sql .= "'".$fechaVacia."', "; // Fecha de modificacion
        $sql .= "(NOW()))"; // Fecha del ultimo login

        return $this->db->queryNoSelect($sql);
    }

    public function getUsuarios() {
        $sql = "SELECT * FROM admon WHERE baja=0";
        $data = $this->db->querySelect($sql);
        return $data;
    }

    public function getUsuarioId($id) {
        $sql = "SELECT * FROM admon WHERE id=".$id;
        $data = $this->db->query($sql);
        return $data;
    }

    public function bajaLogica($id) {
        $errores = array();
        $sql = "UPDATE admon SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
        if (!$this->db->queryNoSelect($sql)) {
            array_push($errores, "Error al modificar el registro para baja");
        }
        return $errores;
    }
    public function getLlaves($tipo) {
        $sql = "SELECT * FROM llaves WHERE tipo='".$tipo."' ORDER BY indice DESC";
        $data = $this->db->querySelect($sql);
        return $data;
    }

    public function modificarUsuario($data) {
        $errores = array();
        $sql = "UPDATE admon SET ";
        $sql.= "correo='".$data["correo"]."', ";
        $sql.= "nombre='".$data["nombre"]."', ";
        $sql.= "modificado_dt=(NOW()), ";
        $sql.= "status=".$data["status"];
        
        if (!empty($data["clave1"] && !empty($data["clave2"]))) {
            $clave = hash_hmac("sha512", $data["clave1"], LLAVE);
            $sql .= ", clave='".$clave."'";
        }

        $sql .= " WHERE id=".$data["id"];

        if (!$this->db->queryNoSelect($sql)) {
            array_push($errores, "Existio un error al actualizar el registro.");
        }

        return $errores;
    }
}