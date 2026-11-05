<?php
    session_start();
    require_once '../ConexionBD/funcionesBusqueda.php'; // Ajusta la ruta si es necesario
    $msgError = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usu = trim($_POST['nom_usuario'] ?? '');
        $cont = trim($_POST['pass'] ?? '');

        if ($usu === '' || $cont === '') {
            $msgError = "Por favor, rellena todos los campos.";
        } else {
            // Comprueba credenciales, regenera la sesión y redirige según el rol (ver funcionesBusqueda.php)
            $msgError = verificarUsuPass($usu, $cont);
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Contactos - Inicio de sesión</title>
</head>
<body>
    <h1>AGENDA DE CONTACTOS</h1>
    
    <form action="index.php" method="POST">
        <label for="nom_usuario">USUARIO:</label>
        <input type="text" id="nom_usuario" name="nom_usuario" required><br><br>

        <label for="pass">CLAVE:</label>
        <input type="password" id="pass" name="pass" required><br><br>

        <button type="submit">Entrar</button>
        <button type="button" onclick="window.location.href='./registro.php'">Registrarse</button>
    </form>

    <!-- MENSAJE DE ERROR DINÁMICO SI LOS DATOS SON INCORRECTOS -->
    <?php if ($msgError != ""): ?>
        <p style="color: red; font-weight: bold; margin-top: 15px;">
            <?= $msgError ?>
        </p>
    <?php endif; ?>
</body>
</html>