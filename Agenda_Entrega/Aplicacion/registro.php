<?php
    session_start();
    require_once '../ConexionBD/funcionesBusqueda.php';

    $msgError = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usu = trim($_POST['usuario'] ?? '');
        $pass = $_POST['pass'] ?? '';

        if ($usu === '' || $pass === '') {
            $msgError = "Todos los campos son obligatorios.";
        } elseif (mb_strlen($usu) > 20) {
            $msgError = "El nombre de usuario no puede superar los 20 caracteres.";
        } elseif (existeUsuario($usu)) {
            $msgError = "El nombre de usuario ya existe. Prueba con otro.";
        } else {
            $nuevoId = insertarUsuario($usu, $pass);

            if ($nuevoId !== false) {
                session_regenerate_id(true);
                $_SESSION['cod_usuario'] = $nuevoId;
                $_SESSION['nom_usuario'] = $usu;
                $_SESSION['rol'] = 0;

                header("Location: inicio.php");
                exit();
            }

            $msgError = "Hubo un error al registrar el usuario. Inténtalo de nuevo.";
        }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda de Contactos - Registro de Usuario</title>
</head>
<body>
    <h2>Registro de Usuario</h2>

    <form action="registro.php" method="POST">
        <label for="usuario">Nombre de usuario:</label>
        <input type="text" id="usuario" name="usuario" maxlength="20" required><br><br>

        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass" required><br><br>

        <button type="submit">Registrarse</button>
        <a href="index.php"><button type="button">Volver</button></a>
    </form>

    <?php if ($msgError !== ""): ?>
        <p style="color: red; font-weight: bold; margin-top: 15px;">
            <?= htmlspecialchars($msgError) ?>
        </p>
    <?php endif; ?>
</body>
</html>