<?php
    include 'matematicas.php'; //Incluímos el archivo con las funciones

    // Prueba de ecSegundoGrado()
    $a = 1;
    $b = -5;
    $c = 6;

    $solucionesEc = ecSegundoGrado($a,$b,$c);
    imprimirArray($solucionesEc);
    echo "<br>";

    // Prueba de esPalindromo()
    $cadenaPrueba = "A cavar a Caravaca";
    echo esPalindromo($cadenaPrueba)."<br><br>";

    // Prueba de limiteArray()
    $arrayPrueba = array(1,2,3,4,5,6,7,8,9,25,54,85);
    $limite = 10;
    $arraySol = limiteArray($arrayPrueba, $limite);
    imprimirArray($arraySol);
    echo "<br>";

    //Prueba de funcionLibre()
    $variable = array();
    $string1 = "Hola";
    $string2 = "Mundo";
    $array = array(
        "Clase" => "Servidor",
        "Horas" => "198",
        "Curso" => "2º",
    );

    $key = "Clase";

    funcionLibre($variable, $string1, $string2, $array, $key);
?>