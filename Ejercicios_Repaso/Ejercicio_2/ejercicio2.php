<?php
    session_start();

    if(!isset($_SESSION['posicion'])){
        $_SESSION['posicion'] = 0;
    }

    $cxSVG = 300 + $_SESSION['posicion'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOVER PUNTO A DERECHA E IZQUIERDA</title>
</head>
<body>
    <h1>MOVER UN PUNTO A DERECHA E IZQUIERDA</h1>
    <p>Haga clic en los botones para modificar el valor:</p>
    <!-- Los tres botones comparten el mismo atributo name -->
    <form action="proceso2.php" method="post">
        <button type="submit" name="accion" value="izquierda"><img src="recursos/izquierda.jpg" width="65px" height="55px"/></button>
        <button type="submit" name="accion" value="derecha"><img src="recursos/derecha.jpg" width="65px" height="55px"/></button>
        <br><br>

        <svg width="600" height="60px" style="background-color: #f9f9f9; border: 1px solid #ccc;">
            <!-- Línea horizontal centrada -->
            <line x1="0" y1="30" x2="600" y2="30" stroke="black" stroke-width="3" />
            <!-- Punto rojo cuya coordenada X viene dada por la sesión -->
            <circle cx="<?php echo $cxSVG; ?>" cy="30" r="6" fill="red" />
        </svg>
        <br><br>

        <button type="submit" name="accion" value="centro">Volver al centro</button>
    </form>
</body>
</html>