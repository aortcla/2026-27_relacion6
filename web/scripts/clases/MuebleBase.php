<?php
abstract class MuebleBase {

const MAXIMO_MUEBLES = 5;

private static int $_mueblesCreados = 0;

private string $_nombre;
private string $_fabricante = "FaMu:";
private string $_pais = "ESPAÑA";
private int $_anio = 2020;
private string $_fechaIniVenta = "01/01/2020";
private string $_fechaFinVenta = "31/12/2040";
private float $_precio = 30;

private Caracteristicas $caracteristicas;

public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", int $anio = 2020,
                           string $fechaIniVenta = "01/01/2020", string $fechaFinVenta = "31/12/2040", float $precio = 30){
    if(MuebleBase::$_mueblesCreados < MuebleBase::MAXIMO_MUEBLES){
        if(!$this->setNombre($nombre) || $nombre === ""){
            throw new Exception("Nombre no válido");
        }

        $this->setFabricante($fabricante);
        $this->setPais($pais);
        $this->setAnio($anio);
        $this->setFechaIniVenta($fechaIniVenta);
        $this->setFechaFinVenta($fechaFinVenta);
        $this->setPrecio($precio);

        MuebleBase::$_mueblesCreados++;
    }else{
        throw new Exception("Se ha llegado al limite de muebles creados");
    }
}


/*Getters*/
public function getNombre():string{
    return $this->_nombre;
}

public function getFabricante():string{
    return $this->_fabricante;
}

public function getPais():string{
    return $this->_pais;
}

public function getAnio():string{
    return $this->_anio;
}

public function getFechaIniVenta():string{
    return $this->_fechaIniVenta;
}

public function getFechaFinVenta():string{
    return $this->_fechaFinVenta;
}

public function getPrecio():string{
    return $this->_precio;
}

/*Setters*/
public function setNombre(string $var):bool{

    if(validaCadena($var, 40, "DEFECTO")){
        $this->_nombre = mb_strtoupper($var);
        return true;
    }else{
        return false;
    }
}

public function setFabricante(string $var): bool {
    if (validaCadena($var, 30, "FaMu:")) {
        if (mb_substr($var, 0, 5) === "FaMu:") {
            $this->_fabricante = mb_substr($var, 0, 30);
        } else {
            $this->_fabricante = mb_substr("FaMu:" . $var, 0, 30);
        }
        return true;
    } else {
        return false;
    }
}

public function setPais(string $var):bool{

    if(validaCadena($var, 20, "ESPAÑA")){
        $this->_pais = mb_strtoupper($var);
        return true;
    }else{
        return false;
    }
}

public function setAnio(int $var):bool{

    if(validaEntero($var, 2020, (int)date('Y'), 2020)){
        $this->_anio = $var;
        return true;
    }else{
        return false;
    }
}

public function setFechaIniVenta(string $var): bool {
    $defecto = "01/01/" . $this->_anio;
    
    if (validaFecha($var, $defecto) && strtotime($var) >= strtotime($defecto)) {
        $this->_fechaIniVenta = $var;
        return true;
    } else {
        $this->_fechaIniVenta = $defecto;
        return false;
    }
}

public function setFechaFinVenta(string $var): bool {
    $defecto = "31/12/2040";
    
    if (validaFecha($var, $defecto) && strtotime($var) >= strtotime($this->_fechaIniVenta)) {
        $this->_fechaFinVenta = $var;
        return true;
    } else {
        $this->_fechaFinVenta = $defecto;
        return false;
    }
}

public function setPrecio(float $var):bool{
    if($var >= 30){
        $this->_precio = $var;
        return true;
    }else{
        return false;
    }
}

abstract function damePropiedadesAdicionales();


/**
 * Devuelve el numero de clases que se pueden crear dentro de la variable que se le pasa
 * Ademas devuelve verdadero o falso si se pueden crear mas o no
 *
 * @return bool
 */
static function puedeCrear(int &$num):bool{
    $num = self::MAXIMO_MUEBLES - self::$_mueblesCreados;

    if(self::$_mueblesCreados < self::MAXIMO_MUEBLES){
        return true;
    }else{
        return false;
    }
}
/**
 * Método que al convertir la instancia en cadena nos devuelve 'MUEBLE de clase
 * XXX con nombre XXX, fabricante XXX, fabricado en XXX a partir del año 999,
 * vendido desde 99/99/9999 hasta 99/99/9999, precio 9999'
 *
 * @return string
 */
public function __toString():string{

    $cadena = "MUEBLE de clase ".get_class($this)." con nombre {$this->_nombre}, fabricante {$this->_fabricante},
    fabricado en {$this->_pais} a partir del año {$this->_anio}, vendido desde {$this->_fechaIniVenta}
     hasta {$this->_fechaFinVenta}, precio {$this->_precio}, caracteristicas {$this->caracteristicas}";

    return $cadena;
}

public function anadirCaracteristicas(string $nombre, mixed $valor, mixed ...$demas){

    $this->caracteristicas->__set($nombre, $valor);

    if(count($demas) % 2 !== 0){
        array_pop($demas);
    }

    for ($i = 0; $i < count($demas); $i += 2) {
        $nom = $demas[$i];
        $val = $demas[$i + 1];
        
        $this->caracteristicas->__set($nom, $val);
    }

}

public function getCaracteristicas():Caracteristicas{
    return $this->caracteristicas;
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