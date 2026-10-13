<?php
    session_start();
    $svg_resultado = $_SESSION['svg_resultado'];
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
        <?= $svg_resultado ?>
    </div>

    <a href="resultado.php">Volver</a>
</body>
</html>