<?php

    function imprimirArray(array $elem): void{
        echo "[";
        foreach($elem as $e){
            echo $e."  ";
        }
        echo"]<br>";
    }

    function ecSegundoGrado(float $a, float $b, float $c): array{
        $discriminante = $b**2 - 4*$a*$c;

        if($discriminante > 0){
            $x1 = (-$b + sqrt($discriminante)) / (2 * $a);
            $x2 = (-$b - sqrt($discriminante)) / (2 * $a);

            return array($x1, $x2);
        } elseif ($discriminante == 0) {
            $x = -$b / (2 * $a);

            return array($x);

        } else {
            return array();
        }
    }

    function esPalindromo(string $cadena): string{

        $cadenaTratada = strtolower(str_replace(" ", "", $cadena));
        $cadenaInvertida = strrev($cadenaTratada);

        if($cadenaTratada === $cadenaInvertida){
            return "true";
        }else{
            return "false";
        }
    }

    function limiteArray(array $nums, int $limite): array{
        $res = array();

        foreach($nums as $n){
            if($n < $limite){
                array_push($res, $n);
            }
        }

        return $res;
    }

    // Del primer bloque de funciones, se usarán is_array(), isset() e is_null()
    // Del segundo bloque, se usarán strlen(), strtoupper() y strcmp()
    // Del tercer bloque, se utilizarán count(), array_keys() y array_key_exists()

    // ENUNCIADO FICTICIO: Crea una función que resuelva los siguientes problemas:
    // - Dada una variable, determinar si está inicializada, si tiene asignado el valor null y si es un array
    // - Dadas dos cadenas, se debe imprimir la longitud de ambas cadenas, mostrarlas en mayúsculas y comparar si las cadenas son iguales o no
    // - Dado un array y una clave, mostrar el tamaño del array, sus claves y comprobar si la clave introducida existe en el array
    function funcionLibre($variable, $string1, $string2, $array, $key){
        $cadenaSet = isset($variable) ? "Sí" : "No";
        $cadenaNull = is_null($variable) ? "Sí" : "No";
        $cadenaArray = is_array($variable) ? "Sí" : "No";

        $cadenaCadenasIguales = "";

        if(strcmp($string1, $string2) == 0){
            $cadenaCadenasIguales = "Sí";
        }else{
            $cadenaCadenasIguales = "No";
        }

        $cadenaArrayExists = array_key_exists($key, $array) ? "Sí" : "No";

        echo "¿La variable está definida? ".$cadenaSet."<br>";
        echo "¿La variable tiene el valor Null? ".$cadenaNull."<br>";
        echo "¿La variable es un array? ".$cadenaArray."<br>";

        echo "<br><br>";

        echo "La longitud de la primera cadena es de ".strlen($string1)."<br>";
        echo "La longitud de la segunda cadena es de ".strlen($string2)."<br>";
        echo "La primera cadena en mayúsculas es ".strtoupper($string1)."<br>";
        echo "La segunda cadena en mayúsculas es ".strtoupper($string2)."<br>";
        echo "¿La primera cadena y la segunda son iguales? ".$cadenaCadenasIguales."<br>";

        echo "<br><br>";

        echo "La longitud del array introducido es de ".count($array)."<br>";
        echo "Las claves del array son: ";
        echo imprimirArray(array_keys($array));
        echo "¿Existe la clave $key en el array? ".$cadenaArrayExists;
    }

?>