<?php
    declare(strict_types=1);

    function calcularPromedio(array $numeros): float{
        $suma=0;
        $cont=0;
        $media=0;

        foreach($numeros as $n){
            $suma += $n;
            $cont++;
        }

        $media = $suma / $cont;
        return $media;
    }

    function modificarNotas(array &$notas, float $puntos): void{
        foreach($notas as &$n){
            $n += $puntos;
        }
    }

    function imprimirArray(array $elem): void{
        echo "[";
        foreach($elem as $e){
            echo $e."  ";
        }
        echo"]<br>";
    }
?>