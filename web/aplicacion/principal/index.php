<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador
$barra=[
    [
    "TEXTO"=> "inicio",
    "ENLACE"=> "/index.php"],
    [
    "TEXTO"=> "Principal"
    ],
    [
    "TEXTO"=> "index"
    ],
];


//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Tienda", $barra);
cuerpo($arrayMuebles); //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}
//vista
function cuerpo($arrayMuebles)
{
?>
    <table>
        <thead>
            <td>Indice</td>
            <td>Tipo</td>
            <td>Nombre</td>
            <td>País</td>
            <td>Precio</td>
        </thead>
        <tbody>
            <td>1</td>
            <td><?php echo get_class($arrayMuebles[0]) ?></td>
            <td><?php echo $arrayMuebles[0]->getNombre() ?><td>
            <td><?php echo $arrayMuebles[0]->getPais() ?><td>
            <td><?php echo $arrayMuebles[0]->getPrecio() ?><td>
        </tbody>
    </table>
<?php



}