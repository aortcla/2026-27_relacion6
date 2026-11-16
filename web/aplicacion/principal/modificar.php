<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador
$barra = [
    [
        "TEXTO" => "inicio",
        "ENLACE" => "/index.php"
    ],
    [
        "TEXTO" => "modificacion"
    ]
];

$idMueble = isset($_REQUEST["id_mueble"]);

if (!isset($arrayMuebles[$idMueble])) {
    header("Location: /aplicacion/principal/index.php");
    exit();
}

$mueble = $arrayMuebles[$idMueble];
$errores = [];
$actualizado = false;

$datos = [
    "nombre" => $mueble->getNombre(),
    "fabricante" => $mueble->getFabricante(),
    "pais" => $mueble->getPais(),
    "anio" => $mueble->getAnio(),
    "fechaIniVenta" => $mueble->getFechaIniVenta(),
    "fechaFinVenta" => $mueble->getFechaFinVenta(),
    "precio" => $mueble->getPrecio(),
    "material" => $mueble->getMaterial(),
    "porcentajeReciclado" => ($mueble instanceof MuebleReciclado) ? $mueble->getPorcentajeReciclado() : 10,
    "peso" => ($mueble instanceof MuebleTradicional) ? $mueble->getPeso() : 15,
    "serie" => ($mueble instanceof MuebleTradicional) ? $mueble->getSerie() : "S01"
];

/* Validación formulario */
if (isset($_POST["guardar"])) {
    $datos["nombre"] = trim($_POST["nombre"]);
    $datos["fabricante"] = trim($_POST["fabricante"]);
    $datos["pais"] = trim($_POST["pais"]);
    $datos["anio"] = intval($_POST["anio"]);
    $datos["fechaIniVenta"] = trim($_POST["fechaIniVenta"]);
    $datos["fechaFinVenta"] = trim($_POST["fechaFinVenta"]);
    $datos["precio"] = floatval($_POST["precio"]);
    $datos["material"] = intval($_POST["material"]);

    if ($mueble instanceof MuebleReciclado) {
        $datos["porcentajeReciclado"] = intval($_POST["porcentajeReciclado"]);
    } elseif ($mueble instanceof MuebleTradicional) {
        $datos["peso"] = floatval($_POST["peso"]);
        $datos["serie"] = trim($_POST["serie"]);
    }

    $auxiliar = clone $mueble;

    if (!$auxiliar->setNombre($datos["nombre"])) {
        $errores["nombre"][] = "El nombre no puede estar vacío ni superar los 40 caracteres.";
    }
    if (!$auxiliar->setFabricante($datos["fabricante"])) {
        $errores["fabricante"][] = "El fabricante no es válido (máximo 30 caracteres).";
    }
    if (!$auxiliar->setPais($datos["pais"])) {
        $errores["pais"][] = "El país no es válido (máximo 20 caracteres).";
    }
    if (!$auxiliar->setAnio($datos["anio"])) {
        $errores["año"][] = "El año debe estar comprendido entre 2020 y " . date("Y") . ".";
    }

    $fechaMinima = "01/01/" . $datos["anio"];
    $fechaIni = DateTime::createFromFormat("d/m/Y", $datos["fechaIniVenta"]);
    $fechaMin = DateTime::createFromFormat("d/m/Y", $fechaMinima);

    if (!validaFecha($datos["fechaIniVenta"], $fechaMinima) || !$fechaIni || !$fechaMin || $fechaIni < $fechaMin) {
        $errores["fechaIniVenta"][] = "La fecha de inicio de venta debe ser válida y no anterior al $fechaMinima.";
    }

    $fechaFin = DateTime::createFromFormat("d/m/Y", $datos["fechaFinVenta"]);
    if (!validaFecha($datos["fechaFinVenta"], "31/12/2040") || !$fechaFin || ($fechaIni && $fechaFin < $fechaIni)) {
        $errores["fechaFinVenta"][] = "La fecha de fin de venta debe ser válida y posterior o igual a la fecha de inicio.";
    }

    if ($datos["precio"] < 30) {
        $errores["precio"][] = "El precio no puede ser inferior a 30 €.";
    }

    if ($datos["material"] % 5 !== 0) {
        $errores["material"][] = "El material debe ser multiplo de 5";
    }

    if ($mueble instanceof MuebleReciclado) {
        if ($datos["porcentajeReciclado"] < 0 || $datos["porcentajeReciclado"] > 100) {
            $errores["porcentajeReciclado"][] = "El porcentaje de reciclado debe estar entre 0 y 100.";
        }
    } elseif ($mueble instanceof MuebleTradicional) {
        if ($datos["peso"] < 15 || $datos["peso"] > 300) {
            $errores["peso"][] = "El peso debe estar entre 15 y 300 kg.";
        }
        if (!preg_match("/^S\d{2}$/i", $datos["serie"])) {
            $errores["serie"][] = "La serie debe tener el formato S seguido de 2 dígitos (ej. S01).";
        }
    }

    if (empty($errores)) {
        $mueble->setNombre($datos["nombre"]);
        $mueble->setFabricante($datos["fabricante"]);
        $mueble->setPais($datos["pais"]);
        $mueble->setAnio($datos["anio"]);
        $mueble->setFechaIniVenta($datos["fechaIniVenta"]);
        $mueble->setFechaFinVenta($datos["fechaFinVenta"]);
        $mueble->setPrecio($datos["precio"]);
        $mueble->setMaterial($datos["material"]);

        if ($mueble instanceof MuebleReciclado) {
            $mueble->setPorcentajeReciclado($datos["porcentajeReciclado"]);
        } elseif ($mueble instanceof MuebleTradicional) {
            $mueble->setPeso($datos["peso"]);
            $mueble->setSerie($datos["serie"]);
        }

        $actualizado = true;
    }
}

//dibuja la plantilla de la vista
inicioCabecera("inicio");
cabecera();
finCabecera();
inicioCuerpo("INICIO", $barra);
cuerpo($idMueble, $mueble, $datos, $errores, $actualizado);  //llamo a la vista
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
function cuerpo(int $idMueble, MuebleBase $mueble, array $datos, array $errores, bool $actualizado)
{
?>
    <?php
    echo "<h2>Modificando: ". $mueble->getNombre() ." - ". get_class($mueble) ."</h2>";

    if (!empty($errores)) { // Muestro los errores
        echo "<div class='error'>";
        foreach ($errores as $clave => $valor) {
            foreach ($valor as $error)
                echo "$clave => $error<br>" . PHP_EOL;
        }
        echo "</div>";
    }

    if ($actualizado) {
        echo "<div class='resumen'>";
        echo "<h3>Mueble actualizado. Resumen:</h3>";
        echo "<ul>";
        echo "<li><strong>Nombre:</strong> " . $mueble->getNombre() . "</li>";
        echo "<li><strong>Fabricante:</strong> " . $mueble->getFabricante() . "</li>";
        echo "<li><strong>País:</strong> " . $mueble->getPais() . "</li>";
        echo "<li><strong>Año:</strong> " . $mueble->getAnio() . "</li>";
        echo "<li><strong>Fecha Inicio Venta:</strong> " . $mueble->getFechaIniVenta() . "</li>";
        echo "<li><strong>Fecha Fin Venta:</strong> " . $mueble->getFechaFinVenta() . "</li>";
        echo "<li><strong>Precio:</strong> " . number_format($mueble->getPrecio(), 2) . " €</li>";
        echo "<li><strong>Material:</strong> " . $mueble->getMaterialDescripcion() . "</li>";

        if ($mueble instanceof MuebleReciclado) {
            echo "<li><strong>Porcentaje Reciclado:</strong> " . $mueble->getPorcentajeReciclado() . "%</li>";
        } elseif ($mueble instanceof MuebleTradicional) {
            echo "<li><strong>Peso:</strong> " . $mueble->getPeso() . " kg</li>";
            echo "<li><strong>Serie:</strong> " . $mueble->getSerie() . "</li>";
        }

        echo "</ul>";
        echo "</div>";
        echo "<p><a href='/aplicacion/principal/index.php'>Volver a Index.php</a></p>";
    } else {
        echo "<form method='post' action='#'>";
        echo "<input type='hidden' name='id_mueble' value='" . $idMueble . "'>";

        echo "<div class='campo'>";
        echo "<label for='nombre'>Nombre:</label>";
        echo "<input type='text' id='nombre' name='nombre' value='" . $datos["nombre"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='fabricante'>Fabricante:</label>";
        echo "<input type='text' id='fabricante' name='fabricante' value='" . $datos["fabricante"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='pais'>País:</label>";
        echo "<input type='text' id='pais' name='pais' value='" . $datos["pais"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='anio'>Año de fabricación:</label>";
        echo "<input type='number' id='anio' name='anio' value='" . $datos["anio"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='fechaIniVenta'>Fecha Inicio Venta (dd/mm/aaaa):</label>";
        echo "<input type='text' id='fechaIniVenta' name='fechaIniVenta' value='" . $datos["fechaIniVenta"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='fechaFinVenta'>Fecha Fin Venta (dd/mm/aaaa):</label>";
        echo "<input type='text' id='fechaFinVenta' name='fechaFinVenta' value='" . $datos["fechaFinVenta"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='precio'>Precio (€):</label>";
        echo "<input type='number' step='0.01' id='precio' name='precio' value='" . $datos["precio"] . "'>";
        echo "</div>";

        echo "<div class='campo'>";
        echo "<label for='material'>Material :</label>";
        echo "<input type='number' id='material' name='material' value='" . $datos["material"] . "'>";
        echo "</div>";

        if ($mueble instanceof MuebleReciclado) {
            echo "<div class='campo'>";
            echo "<label for='porcentajeReciclado'>Porcentaje Reciclado (%):</label>";
            echo "<input type='number' id='porcentajeReciclado' name='porcentajeReciclado' value='" . $datos["porcentajeReciclado"] . "'>";
            echo "</div>";
        } elseif ($mueble instanceof MuebleTradicional) {
            echo "<div class='campo'>";
            echo "<label for='peso'>Peso (kg):</label>";
            echo "<input type='number' step='0.1' id='peso' name='peso' value='" . $datos["peso"] . "'>";
            echo "</div>";

            echo "<div class='campo'>";
            echo "<label for='serie'>Serie (ej. S01):</label>";
            echo "<input type='text' id='serie' name='serie' value='" . $datos["serie"] . "'>";
            echo "</div>";
        }

        echo "<button type='submit' class='boton' name='guardar' value='1'>Guardar Cambios</button>";
        echo "</form>";
        echo "<p><a href='/aplicacion/principal/index.php'>Volver a Index.php</a></p>";
    }
    ?>
<?php

}