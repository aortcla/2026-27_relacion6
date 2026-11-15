<?php
class Caracteristicas implements Iterator{

private array $array_caracteristicas = array();


/*metodos magigos*/
public function __get(string $name):mixed{
    if(isset($this->array_caracteristicas[$name])){
        return $this->array_caracteristicas[$name];
    }else{
        throw new Exception("No existe la caracteristica");
    }
}

public function __set(string $name, mixed $value):void{

    if(isset($this->array_caracteristicas["ULTIMA"])){
        throw new Exception("No se puede añadir la caracteristica, ya está definida ULTIMA");
    }

    if(isset($this->array_caracteristicas[$name])){
        throw new Exception("No se puede añadir la caracteristica, ya existe una con ese nombre");
    }

    $this->array_caracteristicas[$name] = $value;
    

}

public function __isset(string $name):bool{
    
    return isset($this->array_caracteristicas[$name]);

}

public function __unset(string $name):void{
    unset($this->array_caracteristicas[$name]);
}

/*Metodos de Iterator*/
/**
 * Reinicia el iterador y lo sitúa en el ultimo elemento (para que empiece el inverso)
 */
public function rewind(): void {
    $this->keys = array_keys($this->array_caracteristicas);
    $this->position = count($this->keys) - 1;
}

/**
 * Devuelve el valor del elemento actual
 */
public function current(): mixed {
    $key = $this->keys[$this->position];
    return $this->array_caracteristicas[$key];
}

/**
 * Devuelve la clave del elemento actual
 */
public function key(): mixed {
    return $this->keys[$this->position];
}

/**
 * Avanza el puntero hacia atrás (decremente la posición)
 */
public function next(): void {
    $this->position--;
}

/**
 * Comprueba si la posición actual sigue siendo válida
 */
public function valid(): bool {
    return isset($this->keys[$this->position]) && $this->position >= 0;
}

/*toString*/
public function __toString(): string {
    $cadena = "";

    foreach ($this->array_caracteristicas as $clave => $valor) {
        $cadena .= $clave . ":" . $valor . ";";
    }

    return $cadena;
}

}
?>