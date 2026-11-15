<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador
$barra = [
    [
        "TEXTO" => "inicio",
        "ENLACE" => "/index.php"
    ],
    [
        "TEXTO" => "inicio-tienda"
    ]
];

$muebleSeleccionado = null;
$indiceSeleccionado = 1;


if(isset($_REQUEST["mostrar"]))
{
    $indiceSeleccionado = intval($_REQUEST["id_mueble"]);
    $muebleSeleccionado = $arrayMuebles[$indiceSeleccionado];


}







//dibuja la plantilla de la vista
inicioCabecera("inicio");
cabecera();
finCabecera();
inicioCuerpo("INICIO", $barra);
cuerpo($arrayMuebles, $muebleSeleccionado, $indiceSeleccionado);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera()
{
?>
    <!--Esto va en el head-->
<?php
}

//vista
function cuerpo(array $muebles, ?MuebleBase $muebleSeleccionado, int $indiceSeleccionado)
{
?>
    <h2>Listado de Muebles Disponibles</h2>

    <!-- Tabla con 5 o más columnas -->
    <table class="tabla">
        <thead>
            <tr>
                <th>Índice</th>
                <th>Tipo de Mueble</th>
                <th>Nombre</th>
                <th>Fabricante</th>
                <th>País</th>
                <th>Año</th>
                <th>Precio (€)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($muebles as $indice => $mueble)
            {
                echo "<tr>
                    <td>$indice </td>
                    <td>". get_class($mueble) ."</td>
                    <td>". $mueble->getNombre() ."</td>
                    <td>". $mueble->getFabricante() ."</td>
                    <td>". $mueble->getPais() ."</td>
                    <td>". $mueble->getAnio() ."</td>
                    <td>". number_format($mueble->getPrecio(), 2)  ."€</td>
                </tr>".PHP_EOL;
            }
            ?>
        </tbody>
    </table>

    <form method="post" action="index.php">
        <label for="id_mueble"><strong>Selecciona un mueble:</strong></label>
        <select name="id_mueble" id="id_mueble">
            <?php 
                foreach($muebles as $clave => $valor)
                {
                    echo "<option value='$clave' ". ($clave===$indiceSeleccionado? 'selected' : '') .">". $clave ." - ". get_class($valor) . ": ". $valor->getNombre() ."</option>".PHP_EOL;
                }
            
            ?>
        </select>

        <button type="submit" name="mostrar" class="boton">Mostrar Mueble</button>
        <button type="submit" name="modificar" class="boton" formaction="modificar.php" formtarget="_blank">Modificar Mueble</button>
    </form>
<?php
    if($muebleSeleccionado!==null)
    {
        echo "<h3>Detalles del Mueble $indiceSeleccionado</h3>".PHP_EOL;
        echo "<p>Tipo: ". get_class($muebleSeleccionado) ."</p>".PHP_EOL;
        echo "<p>Nombre: ". $muebleSeleccionado->getNombre() ."</p>".PHP_EOL;
        echo "<p>Fabricante: ". $muebleSeleccionado->getFabricante()."</p>".PHP_EOL;
        echo "<p>País: ". $muebleSeleccionado->getPais() ."</p>".PHP_EOL;
        echo "<p>Año de fabricación: ". $muebleSeleccionado->getAnio() ."</p>".PHP_EOL;
        echo "<p>Fecha inicio venta: ". $muebleSeleccionado->getFechaIniVenta() ."</p>".PHP_EOL;
        echo "<p>Fecha fin venta: ". $muebleSeleccionado->getFechaFinVenta() ."</p>".PHP_EOL;
        echo "<p>Precio: ". $muebleSeleccionado->getPrecio() ."</p>".PHP_EOL;

        foreach($muebleSeleccionado->damePropiedadesAdicionales() as $prop => $valor)
        {
            $nombrePropiedad = mb_substr($prop, 1, mb_strlen($prop));
            $primeraLetra = $nombrePropiedad[0];
            $nombrePropiedad = str_replace($primeraLetra, mb_strtoupper($primeraLetra), $nombrePropiedad);

            $metodo = "get".$nombrePropiedad;

            echo "<p>$nombrePropiedad: ". $muebleSeleccionado->$metodo() ."</p>".PHP_EOL;
        }
    }
}