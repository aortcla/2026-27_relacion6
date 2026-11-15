<?php 

include_once(dirname(__FILE__) . "/scripts/librerias/validacion.php");
date_default_timezone_set('Europe/Madrid'); // Configurar la zona horaria

define("RUTABASE", dirname(__FILE__));
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO","desarrollo"); //en "produccion o en desarrollo

if (MODO_TRABAJO=="produccion")
    error_reporting(0);
    else 
        error_reporting(E_ALL);  

spl_autoload_register(function ($clase){
    $ruta=RUTABASE."/aplicacion/clases/curso2026/";
    $fichero=$ruta."$clase.php";
    
    if (file_exists($fichero))
        {
            require_once($fichero);
        }
      else
        {
            throw new Exception("La clase $clase no se ha encontrado.");
        }
});

include(RUTABASE."/aplicacion/plantilla/plantilla.php");

//creo todos los objetos que necesita mi aplicación

include_once __DIR__ . '/scripts/librerias/validacion.php';

$arrayMuebles = [
    new MuebleTradicional(
    nombre: "Mesa de comedor extensible",
    fabricante: "Carpintería Ibérica",
    pais: "ESPAÑA",
    anio: 2023,
    fechaIniVenta: "01/06/2023",
    fechaFinVenta: "31/12/2035",
    precio: 180.50,
    peso: 45.0,
    serie: "S02"
),
    new MuebleTradicional(
    nombre: "Estantería de nogal",
    fabricante: "Mobiliario Italiano",
    pais: "ITALIA",
    anio: 2021,
    fechaIniVenta: "15/09/2021",
    fechaFinVenta: "31/12/2028",
    precio: 120.00,
    peso: 30.5,
    serie: "S08"
),
    new MuebleTradicional(
    nombre: "Cómoda de 4 cajones",
    fabricante: "WoodCraft Design",
    pais: "ALEMANIA",
    anio: 2024,
    fechaIniVenta: "01/02/2024",
    fechaFinVenta: "31/12/2040",
    precio: 210.75,
    peso: 55.0,
    serie: "S15"
),
    new MuebleReciclado(
    nombre: "Banco de jardín de madera recuperada",
    fabricante: "EcoMuebles Sur",
    pais: "ESPAÑA",
    anio: 2024,
    fechaIniVenta: "01/03/2024",
    fechaFinVenta: "31/12/2038",
    precio: 130.00,
    porcentajeReciclado: 90
),
    new MuebleReciclado(
    nombre: "Estantería industrial reciclada",
    fabricante: "ReDesign Lab",
    pais: "ITALIA",
    anio: 2022,
    fechaIniVenta: "15/08/2022",
    fechaFinVenta: "31/12/2030",
    precio: 160.25,
    porcentajeReciclado: 75
)
];