<?php
    session_start();
    $color_form = isset($_COOKIE['cookie_fondo']) ? $_COOKIE['cookie_fondo'] : 'grey';
    $num_cir_cookie = isset($_COOKIE['cookie_circulos']) ? $_COOKIE['cookie_circulos'] : '7';
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simón dice... - Configuración</title>
</head>
<body style='background-color: <?=$color_form?>'>
    <h2>¡Hola, <?= $_SESSION['nom_usuario'] ?>! Configura tu partida:</h2>
    <form action="solucion.php" method="POST">

        <label for="num_circulos">Número de círculos (entre 4 y 8):</label>
        <input type="number" id="num_circulos" name="num_circulos" value=<?=$num_cir_cookie?> min="4" max="8" required><br><br>

        <label for="num_colores">Número de colores a usar (entre 2 y 8):</label>
        <input type="number" id="num_colores" name="num_colores" value="4" min="2" max="8" required><br><br>

        <label for="color_fondo">Color de fondo:</label>
        <input type="text" id="color_fondo" name="color_fondo" value=<?=$color_form?> ><br><br>
        
        <!-- Contenedor en línea para alinear ambos botones juntos -->
        <div style="display: inline-flex; gap: 10px; align-items: center;">
            <a href="index.php"><button type="button">Volver al inicio</button></a>
            <button type="submit">Siguiente</button>
        </div>
    </form>
</body>
</html>