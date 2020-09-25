<?php
/**
 * Administrador Modelo
 */
class AdmonModelo{
  private $db;

  function __construct()
  {
    $this->db = new MySQLdb();
  }

  function verificarClave($data) {
    // Arreglo
    $errores = array();

    // Encriptar clave
    $clave = hash_hmac("sha512", $data["clave"], "mimamamemima");
    // $clave = hash_hmac("sha512", $data["clave"], LLAVE);

    // Enviar el query
    $sql = "SELECT id, clave, status, baja FROM admon WHERE correo='".$data['usuario']."'";
    $data = $this->db->query($sql);
    // Verificación
    if (empty($data)) {
        array_push($errores, "No existe el usuario");
    } else if ($clave!=$data["clave"]) {
      array_push($errores, "La clave de acceso no es correcta");
    } else if ($data["status"] == 0) {
      array_push($errores, "EL usuario esta desactivado.");
    }else if ($data["baja"] == 1) {
      array_push($errores, "EL usuario no existe (Esta dado de baja).");
    }else if (count($data)>4) {
      array_push($errores, "El correo electrónico esta duplicado");
    } else {
      $sql = "UPDATE admon SET login_dt=NOW() WHERE id=".$data["id"];
      if (!$this->db->queryNoSelect($sql)) {
        array_push($errores, "Error al modificar la fehca del último acceso");
      }
    }
    // Regresamos los errores
    return $errores;
  }
}
?>