<?php
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST)){
        $usu = $_POST['nom_usuario'];
        $cont = $_POST['pass'];
        require_once './ConexionBD/conexion.php';


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
    <form action="config.php" method="POST">
        <label for="nom_usuario">Nombre:</label>
        <input type="text" id="nom_usuario" name="nom_usuario" required><br><br>

        <label for="num_circulos">Contraseña:</label>
        <input type="password" id="pass" name="pass" required><br><br>

        <table width="100%">
        <tr>
            <!-- Izquierda -->
            <td align="left">
                <button type="button" onclick="window.location.href='./registro.php'">Registro</button>
            </td>
            <!-- Derecha -->
            <td align="right">
                <button type="submit">Entrar</button>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>