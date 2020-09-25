<?php
/**
 * Controlador administrativo
 */
class Admon extends Controlador{
  private $modelo;

  function __construct(){
    $this->modelo = $this->modelo("AdmonModelo");
  }

  public function caratula()
  {
    $datos = [
      "titulo" => "Administrativo",
      "menu" => false,
      "data" => []
    ];
    $this->vista("admonVista",$datos);
  }

  public function verifica() {
    // Arreglos de inicio
    $errores = array();
    $data = array();

    // Verificar la autenticacion del usuario administrativo
    // Recibir datos de la vista
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      // Limpiar datos
      $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
      $clave = isset($_POST["clave"]) ? $_POST["clave"] : "";
      // Validaciones
      if (empty($usuario)) {
        array_push($errores, "El usuario es requerido");
      }
      if (empty($clave)) {
         array_push($errores, "La clave de acceso del usuario es requerida");
      }
      // Arreglo data
      $data = [
        "usuario" => $usuario,
        "clave" => $clave
      ];
      // Verificar errores
      if (empty($errores)) {
        // Ejecutar query
        $errores = $this->modelo->verificarClave($data);
        // No hay errores
        if (empty($errores)) {
          $sesion = new Sesion();
          $sesion->iniciarLogin($data);

          header("Location:".RUTA."admonInicio");
        }         
      }               
    } 
    // Enviar errores a la vista
    $datos = [
      "titulo" => "Administrativo",
      "menu" => false,
      "admon" => true,
      "errores" => $errores,
      "data" => []
    ];
    $this->vista("admonVista",$datos);
  }
}

?>