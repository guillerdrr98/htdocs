<?php
    session_start();
    require_once '../ConexionBD/funcionesBusqueda.php';
    $msgError = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usu = trim($_POST['usuario'] ?? '');
        $pass = trim($_POST['pass'] ?? '');

        if (insertarUsuario($usu, $pass)) {
            // Requisito: Inicia sesión automáticamente y redirige
            header("Location: inicio.php");
            exit();
        } else {
            $msgError = "Hubo un error al registrar el usuario. Inténtalo de nuevo.";
        }

    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>

    <form action="registro.php" method="POST">
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass" required><br><br>

        <button type="button" onclick="window.location.href='./index.php'">Volver</button>
        <button type="submit">Registrarse</button>
    </form>

    <?php if ($msgError != ""): ?>
        <p style="color: red; font-weight: bold; margin-top: 15px;">
            <?= $msgError ?>
        </p>
    <?php endif; ?>
</body>
</html>