<?php
abstract class MuebleBase {

const MAXIMO_MUEBLES = 5;

private static int $_mueblesCreados;

private string $_nombre;
private string $_fabricante = "FaMu";
private string $_pais = "ESPAÑA";
private int $_anio = 2020;
private string $_fechaIniVenta = "01/01/2020";
private string $_fechaFinVenta = "31/12/2040";
private float $_precio = 30;

public function __construct(string $nombre){
    if(MuebleBase::$_mueblesCreados < MuebleBase::MAXIMO_MUEBLES){
        if(!$this->setNombre($nombre)){
            throw new Exception("Nombre no válido");
        }

        MuebleBase::$_mueblesCreados++;
    }else{
        throw new Exception("Se ha llegado al limite de muebles creados");
    }
}


/*Getters*/
public function getNombre():string{
    return $this->_nombre;
}

/*Setters*/
public function setNombre(string $var):bool{

    if(validaCadena($var, 40, "DEFECTO")){
        $this->_nombre = $var;
        return true;
    }else{
        return false;
    }
}

 //Se deshabilita la sobrecarga dinámica de propiedades
public function __set(string $nombre, mixed $valor): void{
    throw new Exception('No existe la propiedad ' . $nombre);
}
 
public function __get(string $nombre): mixed{
    throw new Exception('No existe la propiedad ' . $nombre);
}
 
public function __isset(string $nombre): bool{
    return false;
}
 
public function __unset(string $nombre): void{
    throw new Exception('No existe la propiedad ' . $nombre);
}


}
?>