<?php
    include 'funciones.php'; //Incluímos el archivo con las funciones

    //Llamada a calcularPromedio
    $notasPromedio = array(
        9,10,8,5,2,8,7
    );

    $promedio = calcularPromedio($notasPromedio);
    echo "La media aritmética de las notas del array es $promedio <br>";

    //Llamada a modificarNotas (utilizando recorrerArray)
    $valores = array(
        2,4,3,1,3.5,2,5,5.5,3,4
    );

    echo "Valores del array antes de cambios: <br>";
    imprimirArray($valores);

    modificarNotas($valores, 4);

    echo "Valores del array después de utilizar modificarNotas(): <br>";
    imprimirArray($valores);

    //Intento de meter un tipo diferente del estricto en una de las funciones
    try{
        $prueba = "prueba";
        calcularPromedio($prueba);
    }catch(TypeError $e){
        echo "Tipo de dato inválido";
    }

?>