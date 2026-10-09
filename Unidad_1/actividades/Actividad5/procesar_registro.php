<?php

// Cabecera UTF-8
header('Content-Type: text/html; charset=utf-8');


// Array asociativo con los módulos y sus horas
$modulos = [
    'DWES' => 192,
    'DWEC' => 192,
    'DIW'  => 160,
    'DAW'  => 160,
    'EIE'  => 96
];


// Constante del IVA
const IVA = 0.21;


// Precio de cada hora de matrícula
$precioHora = 10;


// Calculamos el total de horas
$totalHoras = 0;

foreach ($modulos as $modulo => $horas) {
    $totalHoras = $totalHoras + $horas;
}


// Calculamos el coste
$costeBase = $totalHoras * $precioHora;

// Calculamos el IVA
$importeIVA = $costeBase * IVA;

// Coste final
$costeTotal = $costeBase + $importeIVA;


// Función para demostrar el ámbito de variables
function comprobarScope()
{
    // Variable local
    $variableLocal = "Esta variable es local";

    // Accedemos a la variable global
    global $totalHoras;

    echo "Variable local: " . $variableLocal . "<br>";
    echo "Variable global: " . $totalHoras . " horas";
}

?>

<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Registro de módulos</title>
    </head>

    <body>

        <h1>Registro de módulos</h1>

        <table border="1">

            <tr>
                <th>Módulo</th>
                <th>Horas</th>
            </tr>

            <?php

            foreach ($modulos as $modulo => $horas) {

                echo "<tr>";
                echo "<td>" . $modulo . "</td>";
                echo "<td>" . $horas . "</td>";
                echo "</tr>";
            }

            ?>

            <tr>
                <th>Total</th>
                <th><?= $totalHoras; ?></th>
            </tr>

        </table>


        <h2>Coste de matriculación</h2>

        <p>
            Precio por hora:
            <?= $precioHora; ?> €
        </p>

        <p>
            Coste sin IVA:
            <?= $costeBase; ?> €
        </p>

        <p>
            IVA:
            <?= $importeIVA; ?> €
        </p>

        <p>
            <strong>
                Coste total:
                <?= $costeTotal; ?> €
            </strong>
        </p>


        <h2>Comprobación del ámbito de variables</h2>

        <?php

        comprobarScope();

        ?>

    </body>
</html>
