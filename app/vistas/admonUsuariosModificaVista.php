<?php include_once("encabezado.php"); ?>
<h1 class="text-center mt-4">Modificar un usuario administrativo</h1>
<div class="card p-4 bg-light">

  <form action="<?php print RUTA; ?>admonUsuarios/cambio/" method="POST">

    <div class="form-group text-left">
      <label for="correo">* Usuario:</label>
      <input type="email" name="correo" class="form-control"
      placeholder="Escribe tu usuario (tu correo electrónico)" required
      value="<?php 
      print isset($datos['data']['correo'])?$datos['data']['correo']:''; 
      ?>"
      >
    </div>

    <div class="form-group text-left">
      <label for="clave1">* Clave acceso:</label>
      <input type="password" name="clave1" class="form-control"
      placeholder="Escribe tu clave de acceso (sin espacios en blanco)"
      value=""
      >
    </div>

    <div class="form-group text-left">
      <label for="clave2">* Verificar clave:</label>
      <input type="password" name="clave2" class="form-control"
      placeholder="Escribe tu clave de acceso (sin espacios en blanco)"
      value=""
      >
    </div>

    <div class="form-group text-left">
      <label for="nombre">* Nombre:</label>
      <input type="text" name="nombre" class="form-control"
      placeholder="Escribe tu nombre" required
      value="<?php 
      print isset($datos['data']['nombre'])?$datos['data']['nombre']:''; 
      ?>"
      >
    </div>

    <div class="form-group">
      <label for="status">Seleccionar Status</label>
      <select class="form-control" name="status" id="status">
          <option value="void">Seleccionar Status del usuario</option>
          <?php
            for ($i=0; $i < count($datos["status"]) ; $i++) { 
              print "<option value='".$datos["status"][$i]["indice"]."'";
              if ($datos["status"][$i]["indice"] == $datos["data"]["status"]) {
                print " selected ";
              }
              print ">".$datos["status"][$i]["cadena"]."</option>";
            }
          ?>
      </select>
    </div>

    <div class="form-group text-left">
      <input type="hidden" id="id" name="id" value="<?php print $datos['data']['id']; ?>">
      <input type="submit" value="Enviar" class="btn btn-success">
      <a href="<?php print RUTA;?>admonUsuarios" class="btn btn-info">Regresar</a>
    </div>
  </form>
</div><!--card-->
<?php include_once("piepagina.php"); ?>