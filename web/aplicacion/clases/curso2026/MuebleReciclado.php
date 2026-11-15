<?php

final class MuebleReciclado extends MuebleBase{

private int $_porcentajeReciclado = 10;


public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA", int $anio = 2020,
                             string $fechaIniVenta = "01/01/2020", string $fechaFinVenta = "31/12/2040", float $precio = 30,
                              int $porcentajeReciclado = 10){

    parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);

    if(!$this->setPorcentajeReciclado($porcentajeReciclado)){
        $this->_porcentajeReciclado = 10;
    }
}

public function getPorcentajeReciclado():int{
    return $this->_porcentajeReciclado;
}

public function setPorcentajeReciclado(int &$var):bool{
    if(validaEntero($var, 0, 100, 10)){
        $this->_porcentajeReciclado = $var;
        return true;
    }else{
        return false;
    }
}

#[Override]
public function damePropiedadesAdicionales(): array{
    return get_class_vars(get_class($this));
}

#[Override]
public function __toString():string{
    $cadena = parent::__toString() . " Porcentaje de Reciclado del {$this->_porcentajeReciclado}";

    return $cadena;
}

}
?>