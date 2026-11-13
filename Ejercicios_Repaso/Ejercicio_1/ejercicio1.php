<?php
    session_start();

    // Inicializar la variable de sesión si no existe
    if (!isset($_SESSION['numero'])) {
        $_SESSION['numero'] = 0;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUBIR Y BAJAR NÚMERO</title>
</head>
<body>
    <h1>SUBIR Y BAJAR NÚMERO</h1>
    <p>Haga clic en los botones para modificar el valor:</p>
    <!-- Los tres botones comparten el mismo atributo name -->
    <form action="proceso1.php" method="post">
        <button type="submit" name="accion" value="bajar">-</button>
        <span><strong><?php echo $_SESSION['numero']; ?></strong></span>
        <button type="submit" name="accion" value="subir">+</button>
        <br><br>
        <button type="submit" name="accion" value="cero">Poner a cero</button>
    </form>
</body>
</html>