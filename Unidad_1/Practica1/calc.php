<?php

$num1 = $_POST["num1"];
$num2 = $_POST["num2"];
$operacion = $_POST["operacion"];

/*
switch ($operacion) {
    case "+":
        $resultado = $num1 + $num2;
        break;

    case "-":
        $resultado = $num1 - $num2;
        break;

    case "*":
        $resultado = $num1 * $num2;
        break;

    case "/":
        if ($num2 == 0) {
            echo "No se puede dividir entre cero.";
            exit;
        }
        $resultado = $num1 / $num2;
        break;

    default:
        echo "Operación no válida.";
        exit;
}
*/

$resultado = match($operacion){
    "+" => $num1 + $num2,
    "-" => $num1 - $num2,
    "*" => $num1 * $num2,
    "/" => $num1 / $num2,
    default => "Operación no válida",
};

echo "El resultado de $num1 $operacion $num2 es $resultado";

?>