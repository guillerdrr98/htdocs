<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['color_fondo_cookie'])){
        $color = $_POST['color_fondo_cookie'];
        setcookie('color', $color);
    }

    $color_form = isset($_COOKIE['color']) ? $_COOKIE['color'] : 'grey';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prueba cookies</title>
</head>
<body style='background-color: <?=$color_form?>'>
    <h2>Configuración Simón dice...</h2>
    <form method="POST" action=''>

        <label for="color_fondo">Color Aplicación:</label>
        <input type="text" id="color_fondo_cookie" name="color_fondo_cookie" value=<?=$color_form?> >

        <button type="submit">Guardar en Cookie</button>
    </form>
</body>
</html>