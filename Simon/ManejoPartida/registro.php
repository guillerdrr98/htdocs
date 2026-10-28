<?php
    session_start();
    require_once '../ConexionBD/funcionesBusqueda.php';
    $msgError = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
        $usu = $_POST['usuario'];
        $pass = $_POST['pass'];

        // Comprobamos si el usuario ya existe
        if (existeUsuario($usu)) {
            $msgError = "El nombre de usuario ya existe. Prueba con otro.";
        } else {
            // Si no existe, procedemos a insertarlo
            if (insertarUsuario($usu, $pass)) {
                header("Location: index.php");
                exit();
            } else {
                // Error genérico de base de datos al insertar
                $msgError = "Hubo un error al registrar el usuario. Inténtalo de nuevo.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simón dice... - Registro de Usuario</title>
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

    <!-- MENSAJE DE ERROR CONDICIONAL DINÁMICO -->
    <?php if ($msgError != ""): ?>
        <p style="color: red; font-weight: bold; margin-top: 15px;">
            <?= $msgError ?>
        </p>
    <?php endif; ?>

</body>
</html>