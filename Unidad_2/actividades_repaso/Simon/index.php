<?php
    session_start();
    require_once './ConexionBD/funcionesBusqueda.php';
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)){
        $usu = $_POST['nom_usuario'];
        $cont = $_POST['pass'];
        verificarUsuPass($usu, $cont);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simon dice... - Inicio de sesión</title>
</head>
<body>
    <h1>Inicio de Sesión</h1>
    <form action="index.php" method="POST">
        <label for="nom_usuario">Nombre:</label>
        <input type="text" id="nom_usuario" name="nom_usuario" required><br><br>

        <label for="num_circulos">Contraseña:</label>
        <input type="password" id="pass" name="pass" required><br><br>

        
        <button type="button" onclick="window.location.href='./registro.php'">Registro</button>
        <button type="submit">Entrar</button>
    </form>

    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <p style="color: red; font-weight: bold; margin-top: 15px;">
            <?= "Usuario o contraseña incorrectos." ?>
        </p>
    <?php endif; ?>
</body>
</html>