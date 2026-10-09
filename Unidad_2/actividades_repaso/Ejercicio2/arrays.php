<?php
    //Creamos el array multidimensional
    $alumnos = array(
        array(
            'nombre' => 'Ana',
            'nota' => 5.0
        ),
        array(
            'nombre' => 'Diego',
            'nota' => 4.5
        ),
        array(
            'nombre' => 'Paula',
            'nota' => 8.0
        ),
        array(
            'nombre' => 'Antonio',
            'nota' => 6.0
        ),
        array(
            'nombre' => 'Andrea',
            'nota' => 3.0
        )
    );
    

    //Usamos array_filter
    $aprobados = array_filter($alumnos, fn($alumno) => $alumno['nota'] >= 5);

    //Ordenamos los aprobados de mayor a menor nota
    usort($aprobados, fn($a, $b) => $b['nota'] <=> $a['nota']);

    //Calculamos la suma de las notas
    $sumaNotas = array_reduce($alumnos, fn($suma, $alumno) => $suma + $alumno['nota'], 0);

    //Calculamos el promedio
    $promedio = $sumaNotas / count($alumnos);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestor de Calificaciones</title>
</head>

<body>

    <h1>Gestor de Calificaciones</h1>


    <!-- Tabla de aprobados -->
    <h2>Ranking de alumnos aprobados</h2>

    <table>
        <tr>
            <th>Posición</th>
            <th>Nombre</th>
            <th>Nota</th>
        </tr>

        <?php
        $posicion = 1;

        foreach ($aprobados as $alumno) {
            echo "<tr>";
            echo "<td>$posicion</td>";
            echo "<td>{$alumno['nombre']}</td>";
            echo "<td>{$alumno['nota']}</td>";
            echo "</tr>";

            $posicion++;
        }
        ?>

    </table>


    <!-- Tabla de estadísticas -->
    <h2>Estadísticas globales</h2>

    <table>
        <tr>
            <th>Estadística</th>
            <th>Valor</th>
        </tr>

        <tr>
            <td>Total de alumnos</td>
            <td><?= count($alumnos) ?></td>
        </tr>

        <tr>
            <td>Alumnos aprobados</td>
            <td><?= count($aprobados) ?></td>
        </tr>

        <tr>
            <td>Suma total de notas</td>
            <td><?= $sumaNotas ?></td>
        </tr>

        <tr>
            <td>Promedio final</td>
            <td><?= number_format($promedio, 2) ?></td>
        </tr>
    </table>

</body>
</html>