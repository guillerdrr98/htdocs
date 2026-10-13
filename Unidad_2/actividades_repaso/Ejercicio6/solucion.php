<?php
    session_start();
    $solucion = $_SESSION['svg_resultado'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Combinación de Colores Solucion</title>
</head>
<body>
    <h2>Solucion obtenida(pintada desde <code>\$_SESSION</code>):</h2>

    <div>
        <?= $solucion ?>
    </div>

    <a href="resultado.php">
        <button>Volver</button>
    </a>
</body>
</html>