<?php
    session_start();

    // Inicializar variables de sesión si no existen
    if (!isset($_SESSION['x'])) {
        $_SESSION['x'] = 0;
    }

    if (!isset($_SESSION['y'])) {
        $_SESSION['y'] = 0;
    }

    // Convertir coordenadas lógicas (-200 a 200) a coordenadas SVG (0 a 400)
    // El centro del plano SVG es (200, 200). 
    $cxSVG = 200 + $_SESSION['x'];
    $cySVG = 200 - $_SESSION['y']; // Invertido porque en SVG el eje Y baja
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOVER UN PUNTO EN DOS DIMENSIONES</title>
</head>
<body>
    <h1>MOVER UN PUNTO EN DOS DIMENSIONES</h1>
    <p>Haga clic en los botones para mover el punto:</p>
    
    <form action="proceso3.php" method="post">
        <!-- Tabla principal para poner la cruz de botones y el gráfico lado a lado sin CSS -->
        <table>
            <tr>
                <!-- Columna izquierda: Cruz de botones -->
                <td>
                    <table>
                        <tr>
                            <td></td>
                            <td><button type="submit" name="accion" value="arriba"><img src="recursos/arriba.jpg" width="70px" height="75px"/></button></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><button type="submit" name="accion" value="izquierda"><img src="recursos/izquierda.jpg" width="70px" height="75px"/></button></td>
                            <td><button type="submit" name="accion" value="centro">Volver al centro</button></td>
                            <td><button type="submit" name="accion" value="derecha"><img src="recursos/derecha.jpg" width="70px" height="75px"/></button></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><button type="submit" name="accion" value="abajo"><img src="recursos/abajo.jpg" width="70px" height="75px"/></button></td>
                            <td></td>
                        </tr>
                    </table>
                </td>

                <!-- Separación opcional entre columnas -->
                <td width="30"></td>

                <!-- Columna derecha: Cuadrado SVG de 400x400 con borde negro y punto rojo -->
                <td>
                    <svg width="400" height="400">
                        <!-- Borde negro del cuadrado hecho en SVG -->
                        <rect x="0.5" y="0.5" width="399" height="399" stroke="black" stroke-width="1" fill="white" />
                        <!-- Punto rojo -->
                        <circle cx="<?php echo $cxSVG; ?>" cy="<?php echo $cySVG; ?>" r="6" fill="red" />
                    </svg>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>