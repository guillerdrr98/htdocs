<?php
    session_start();
    $solucion_negro = $_SESSION['svg_negro'];
    $numero_circulos = $_SESSION['num_circulos'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Combinación de Colores Solucion</title>
</head>
<body>
    <h2>Círculos Negros (deberían ser <?= $numero_circulos?>):</h2>

    <div>
        <?= $solucion_negro ?>
    </div>

    <a href="resultado.php">
        <button>Volver</button>
    </a>
</body>
</html>