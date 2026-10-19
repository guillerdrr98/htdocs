<?php
    // DECLARACIÓN COOKIE DE PRUEBA (EN LUGAR DE FIJAR UN VALOR A MANO PARA LOS CÍRCULOS, CREAREMOS UNA COOKIE CON EL VALOR QUE QUERAMOS)
    $nombreCookie = 'cookie_circulos';
    $valorCookie = '7';
    $tiempoExpiracion = time() + (86400 * 30); // 30 días de duración
    setcookie($nombreCookie, $valorCookie, [
        'expires' => $tiempoExpiracion,
        'path' => '/',
        'domain' => 'localhost',
        'secure' => false, // Poner true en producción con HTTPS
        'httponly' => true, // Inaccesible desde JavaScript (Protección Anti-XSS)
        'samesite' => 'Lax' // Protección Anti-CSRF
    ]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simón dice... - Configuración</title>
</head>
<body>
    <h2>Configuración Simón dice...</h2>
    <form action="solucion.php" method="POST">
        <label for="nom_usuario">Nombre:</label>
        <input type="text" id="nom_usuario" name="nom_usuario" required><br><br>

        <label for="num_circulos">Número de círculos (entre 4 y 8):</label>
        <input type="number" id="num_circulos" name="num_circulos" value=<?=$_COOKIE['cookie_circulos']?> min="4" max="8" required><br><br>

        <label for="num_colores">Número de colores a usar (entre 2 y 8):</label>
        <input type="number" id="num_colores" name="num_colores" value="4" min="2" max="8" required><br><br>

        <button type="submit">Siguiente</button>
    </form>
</body>
</html>