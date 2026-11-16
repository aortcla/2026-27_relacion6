
<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


// Creamos un mueble tradicional
$mueble1 = new MuebleTradicional(
    "Mesa de prueba",
    "Carpintería Ángel",
    "ESPAÑA",
    2024,
    "01/01/2024",
    "31/12/2030",
    150.50,
    5,
    40,
    "S05"
);

// Creamos un mueble reciclado
$mueble2 = new MuebleReciclado(
    "Silla reciclada de prueba",
    "EcoMuebles",
    "ESPAÑA",
    2023,
    "01/01/2023",
    "31/12/2030",
    75.50,
    10,
    80
);

inicioCabecera("PRUEBAS");
cabecera();
finCabecera();

inicioCuerpo("Pruebas de muebles");
cuerpo($mueble1, $mueble2);
finCuerpo();

function cabecera() {
}

function cuerpo($mueble1, $mueble2) {
?>

    <h2>Pruebas del mueble tradicional</h2>

    <h3>Getters</h3>

    <p>Nombre: <?php echo $mueble1->getNombre(); ?></p>
    <p>Fabricante: <?php echo $mueble1->getFabricante(); ?></p>
    <p>País: <?php echo $mueble1->getPais(); ?></p>
    <p>Año: <?php echo $mueble1->getAnio(); ?></p>
    <p>Fecha inicial: <?php echo $mueble1->getFechaIniVenta(); ?></p>
    <p>Fecha final: <?php echo $mueble1->getFechaFinVenta(); ?></p>
    <p>Precio: <?php echo $mueble1->getPrecio(); ?></p>
    <p>Peso: <?php echo $mueble1->getPeso(); ?></p>
    <p>Serie: <?php echo $mueble1->getSerie(); ?></p>

    <h3>Setters</h3>

    <?php
    $nombre = "Mesa modificada";
    $mueble1->setNombre($nombre);

    $fabricante = "Nuevo fabricante";
    $mueble1->setFabricante($fabricante);

    $pais = "ITALIA";
    $mueble1->setPais($pais);

    $anio = 2025;
    $mueble1->setAnio($anio);

    $fechaIni = "01/02/2025";
    $mueble1->setFechaIniVenta($fechaIni);

    $fechaFin = "31/12/2035";
    $mueble1->setFechaFinVenta($fechaFin);

    $precio = 200.50;
    $mueble1->setPrecio($precio);

    $peso = 50.0;
    $mueble1->setPeso($peso);

    $serie = "S10";
    $mueble1->setSerie($serie);
    ?>

    <p>Nombre modificado: <?php echo $mueble1->getNombre(); ?></p>
    <p>Fabricante modificado: <?php echo $mueble1->getFabricante(); ?></p>
    <p>País modificado: <?php echo $mueble1->getPais(); ?></p>
    <p>Año modificado: <?php echo $mueble1->getAnio(); ?></p>
    <p>Fecha inicial modificada: <?php echo $mueble1->getFechaIniVenta(); ?></p>
    <p>Fecha final modificada: <?php echo $mueble1->getFechaFinVenta(); ?></p>
    <p>Precio modificado: <?php echo $mueble1->getPrecio(); ?></p>
    <p>Peso modificado: <?php echo $mueble1->getPeso(); ?></p>
    <p>Serie modificada: <?php echo $mueble1->getSerie(); ?></p>

    <h3>Métodos adicionales</h3>
    <p>
        Mueble convertido a texto:
        <?php echo $mueble1; ?>
    </p>

    <h3>Características</h3>

    <?php
    $mueble1->anadirCaracteristicas(
        "COLOR",
        "MARRÓN",
        "MATERIAL",
        "MADERA",
        "ALTURA",
        80
    );
    ?>

    <p>Características:</p>
    <p><?php echo $mueble1->getCaracteristicas(); ?></p>

    <p>Color: <?php echo $mueble1->getCaracteristicas()->COLOR; ?></p>

    <p>¿Existe COLOR?</p>

    <?php
    if (isset($mueble1->getCaracteristicas()->COLOR)) {
        echo "Sí existe la característica COLOR";
    } else {
        echo "No existe la característica COLOR";
    }
    ?>

    <hr>

    <h2>Pruebas del mueble reciclado</h2>

    <h3>Getters</h3>

    <p>Nombre: <?php echo $mueble2->getNombre(); ?></p>
    <p>Fabricante: <?php echo $mueble2->getFabricante(); ?></p>
    <p>País: <?php echo $mueble2->getPais(); ?></p>
    <p>Año: <?php echo $mueble2->getAnio(); ?></p>
    <p>Fecha inicial: <?php echo $mueble2->getFechaIniVenta(); ?></p>
    <p>Fecha final: <?php echo $mueble2->getFechaFinVenta(); ?></p>
    <p>Precio: <?php echo $mueble2->getPrecio(); ?></p>
    <p>Porcentaje reciclado:
        <?php echo $mueble2->getPorcentajeReciclado(); ?> %
    </p>

    <h3>Setters</h3>

    <?php
    $nombre2 = "Silla modificada";
    $mueble2->setNombre($nombre2);

    $fabricante2 = "Otro fabricante";
    $mueble2->setFabricante($fabricante2);

    $pais2 = "FRANCIA";
    $mueble2->setPais($pais2);

    $anio2 = 2025;
    $mueble2->setAnio($anio2);

    $fechaIni2 = "01/03/2025";
    $mueble2->setFechaIniVenta($fechaIni2);

    $fechaFin2 = "31/12/2035";
    $mueble2->setFechaFinVenta($fechaFin2);

    $precio2 = 100.50;
    $mueble2->setPrecio($precio2);

    $porcentaje = 95;
    $mueble2->setPorcentajeReciclado($porcentaje);
    ?>

    <p>Nombre modificado: <?php echo $mueble2->getNombre(); ?></p>
    <p>Fabricante modificado: <?php echo $mueble2->getFabricante(); ?></p>
    <p>País modificado: <?php echo $mueble2->getPais(); ?></p>
    <p>Año modificado: <?php echo $mueble2->getAnio(); ?></p>
    <p>Fecha inicial modificada: <?php echo $mueble2->getFechaIniVenta(); ?></p>
    <p>Fecha final modificada: <?php echo $mueble2->getFechaFinVenta(); ?></p>
    <p>Precio modificado: <?php echo $mueble2->getPrecio(); ?></p>
    <p>Porcentaje reciclado modificado:
        <?php echo $mueble2->getPorcentajeReciclado(); ?> %
    </p>

    <h3>Métodos adicionales</h3>

    <p>
        Mueble convertido a texto:
        <?php echo $mueble2; ?>
    </p>

    <h3>Características</h3>

    <?php
    $mueble2->anadirCaracteristicas(
        "COLOR",
        "BLANCO",
        "MATERIAL",
        "PLÁSTICO RECICLADO"
    );
    ?>

    <p>Características:</p>
    <p><?php echo $mueble2->getCaracteristicas(); ?></p>

    <p>Material: <?php echo $mueble2->getCaracteristicas()->MATERIAL; ?></p>

    <p>¿Existe MATERIAL?</p>

    <?php
    if (isset($mueble2->getCaracteristicas()->MATERIAL)) {
        echo "Sí existe la característica MATERIAL";
    } else {
        echo "No existe la característica MATERIAL";
    }
    ?>

    <hr>

    <h2>Prueba del método estático puedeCrear</h2>

    <?php
    $numero = 0;

    if (MuebleBase::puedeCrear($numero)) {
        echo "Se pueden crear más muebles";
    } else {
        echo "No se pueden crear más muebles";
    }

    echo "<p>Número: " . $numero . "</p>";
    ?>

    <h2>Prueba de material</h2>
<?php
    echo $mueble1->getMaterial()."<br>"; //devuelve el valor numerico del material  
    echo $mueble1->setMaterial(15)."<br>";// devuelve 1 porque es true y se cambia el valor del material
    echo $mueble1->getMaterial()."<br>";//devuelve el valor numerico del material 
    echo $mueble1->getMaterialDescripcion();
?>

<?php
}
?>
