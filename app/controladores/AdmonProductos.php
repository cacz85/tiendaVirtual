<?php
// Controlador para productos
class AdmonProductos extends Controlador {
    private $modelo;

    function __construct() {
        $this->modelo = $this->modelo("AdmonProductosModelo");
    }

    public function caratula() {
        $sesion = new Sesion();

        if ($sesion->getLogin()) {
            // Leer los datos de la tabla
            $data = $this->modelo->getProductos();
            // Vista cartula por default
            $datos = [
                "titulo" => "Administrativo Productos",
                "menu" => false,
                "admon" => true,
                "data" => $data
            ];
            $this->vista("admonProductosCaratulaVista", $datos);
        } else {
            header("location:".RUTA."admon");
        }
        
    }

    public function alta() {
        //Vista Alta
        $datos = [
        "titulo" => "Administrativo Productos Alta",
        "menu" => false,
        "admon" => true,
        "data" => [],
      ];
      $this->vista("admonProductosAltaVista",$datos);
    }

    public function baja($id="") {

    }

    public function cambio($id="") {

    }

}


?>