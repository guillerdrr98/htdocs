<?php
    $_usuario = 'pepe';
    $_pass = password_hash('abc', PASSWORD_DEFAULT);
    $_errMsg = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)) {
        $usu = $_POST['nom_usuario'];
        $cont = $_POST['pass'];


        if ($usu === $_usuario && password_verify($cont, $_pass)) {
            header('Location: destino.php');
            exit;
        } else {
            // Si NO se cumple, se crea un mensaje de error y no se mueve de página
            $_errMsg = 'Usuario y/o contraseña incorrecto/s. Acceso denegado';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Ejemplo Accesos</h2>

    <form action="" method="POST">
        <label for="nom_usuario">Usuario:</label>
        <input type="text" id="nom_usuario" name="nom_usuario" required><br><br>

        <label for="num_circulos">Contraseña:</label>
        <input type="password" id="pass" name="pass" required><br><br>

        <button type="submit">Entrar</button><br><br>
    </form>

    <span style= "color: red;"><?=$_errMsg?></span><br>
    <span><?= $_pass?></span>

</body>
</html>