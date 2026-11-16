<?php

final class MuebleTradicional extends MuebleBase{

private float $_peso = 15;
private string $_serie = "S01";

public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "ESPAÑA",
                             int $anio = 2020, string $fechaIniVenta = "01/01/2020", string $fechaFinVenta = "31/12/2040",
                              float $precio = 30, int $material, float $peso = 15, string $serie = "S01")
{
    parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio, $material);

    if(!$this->setPeso($peso)){
        $this->_peso = 15;
    }

    if(!$this->setSerie($serie)){
        $this->_serie = "S01";
    }

}

/*Getters*/
public function getPeso():float{
    return $this->_peso;
}

public function getSerie():string{
    return $this->_serie;
}

/*Setters*/
public function setPeso(float &$var):bool{
    if(validaReal($var, 15, 300, 15)){
        $this->_peso = $var;
        return true;
    }else{
        return false;
    }
}

public function setSerie(string &$var):bool{
    if(validaExpresion($var, "/^S\d{2}$/", "S01")){
        $this->_serie = mb_strtoupper($var);
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
    $cadena = parent::__toString() . " Peso {$this->_peso} Serie {$this->_serie}";

    return $cadena;
}

}
?>