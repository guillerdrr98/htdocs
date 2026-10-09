<?php
// Configurar la zona horaria (ajusta según tu país, p. ej. 'America/Mexico_City', 'America/Buenos_Aires')
date_default_timezone_set('Europe/Madrid');

// Definir variables
$nombreUsuario = "Guillermo";
$fechaActual = date('d/m/Y H:i');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
</head>
<body>

    <h1>¡Hola, <?= $nombreUsuario; ?>!</h1>
    <p>Bienvenido/a a nuestro sitio web.</p>
    <p>Hoy es <strong><?= $fechaActual; ?></strong>.</p>

</body>
</html>