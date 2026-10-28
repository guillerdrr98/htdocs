<?php
    session_start();

    // Seguridad: Solo el administrador (rol 1) puede acceder a esta página
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
        header("Location: index.php");
        exit();
    }

    // Recuperamos todas las cookies para que los inputs recuerden los últimos valores guardados
    $color_form = isset($_COOKIE['cookie_fondo']) ? $_COOKIE['cookie_fondo'] : 'grey';
    $num_cir_cookie = isset($_COOKIE['cookie_circulos']) ? $_COOKIE['cookie_circulos'] : '7';
    $num_colores_cookie = isset($_COOKIE['cookie_colores']) ? $_COOKIE['cookie_colores'] : '4';

    $_SESSION['fondo'] = $color_form;
    $_SESSION['num_circulos'] = $num_cir_cookie;
    $_SESSION['num_colores'] = $num_colores_cookie;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simón dice... - Configuración</title>
</head>
<body style="background-color: <?= $color_form ?>">
    <h2>Configuración Simón dice...</h2>
    
    <form action="solucion.php" method="POST" autocomplete="off">
        <label for="num_circulos">Número de círculos (entre 4 y 8):</label>
        <input type="number" id="num_circulos" name="num_circulos" value="<?= $num_cir_cookie ?>" min="4" max="8" required autocomplete="off"><br><br>

        <label for="num_colores">Número de colores a usar (entre 2 y 8):</label>
        <input type="number" id="num_colores" name="num_colores" value="<?= $num_colores_cookie ?>" min="2" max="8" required autocomplete="off"><br><br>

        <label for="color_fondo">Color de fondo:</label>
        <input type="text" id="color_fondo" name="color_fondo" value="<?= $color_form ?>" autocomplete="off"><br><br>
    
        <div style="display: inline-flex; gap: 10px; align-items: center;">
            <a href="index.php"><button type="button">Volver al inicio</button></a>
            <button type="submit">Siguiente</button>
        </div>
    </form>
</body>
</html>