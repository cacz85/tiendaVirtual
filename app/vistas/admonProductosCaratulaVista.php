<?php include_once("encabezado.php"); ?>
<h1 class="mt-4 mb-3 text-center">Lista de productos</h1>
<div class="card p-4 bg-light">
    <table class="table table-striped" width="100%">
        <thead>
            <th>id</th>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Modificar</th>
            <th>Borrar</th>
        </thead>
        <tbody>
            <?php
                for ($i=0; $i < count($datos['data']); $i++) { 
                    print "<tr>";
                        print "<td class='text-center'>".$datos["data"][$i]["id"]."</td>";
                        print "<td class='text-left'>".$datos["data"][$i]["tipo"]."</td>";
                        print "<td class='text-left'>".$datos["data"][$i]["nombre"]."</td>";
                        print "<td class='text-left'>".$datos["data"][$i]["descripcion"]."</td>";

                        // Botón modificar
                        print "<td><a href='".RUTA."admonProductos/cambio/".$datos["data"][$i]["id"]."' class='btn btn-info'>Modificar</a></td>";
                        // Botón Borrar
                        print "<td><a href='".RUTA."admonProductos/baja/".$datos["data"][$i]["id"]."' class='btn btn-danger'>Borrar</a></td>";
                    print "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>
<div class="boton text-center">
    <a href="<?php print RUTA; ?>admonProductos/alta" class="btn btn-success btn-lg mt-3 d-inline-block px-5">Dar de alta un producto</a>
</div>
<?php include_once("piepagina.php"); ?>