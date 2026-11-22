<?php
    session_start();
    require_once '../ConexionBD/funcionesBusqueda.php';

    $msgError = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usu = $_POST['nom_usuario'] ?? '';
        $cont = $_POST['pass'] ?? '';

        if ($usu === '' || $cont === '') {
            $msgError = "Debes introducir usuario y contraseña.";
        } else {
            $msgError = verificarUsuPass($usu, $cont);
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
        <a href="registro.php"><button type="button">Registrarse</button></a>
    </form>

    <?php if ($msgError !== ""): ?>
        <p style="color: red; font-weight: bold; margin-top: 15px;">
            <?= htmlspecialchars($msgError) ?>
        </p>
    <?php endif; ?>
</body>
</html>