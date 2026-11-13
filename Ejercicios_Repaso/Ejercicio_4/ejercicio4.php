<?php
    session_start();

    // Inicializar variables de sesión si no existen
    if (!isset($_SESSION['votos_azul'])) {
        $_SESSION['votos_azul'] = 0;
    }
    if (!isset($_SESSION['votos_naranja'])) {
        $_SESSION['votos_naranja'] = 0;
    }

    // El número se multiplica por 10 para los píxeles de la franja SVG (crecen de 10px en 10px)
    $anchoAzul = $_SESSION['votos_azul'] * 10;
    $anchoNaranja = $_SESSION['votos_naranja'] * 10;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VOTAR UNA OPCIÓN</title>
</head>
<body>
    <h1>VOTAR UNA OPCIÓN</h1>
    <p>Haga clic en los botones para votar por una opción:</p>
    
    <form action="proceso4.php" method="post">
        <table>
            <!-- Opción 1: Azul -->
            <tr>
                <td>
                    <button type="submit" name="accion" value="azul"><img src="recursos/azul.png"/></button>
                </td>
                <td>
                    <!-- SVG donde el número de sesión se usa en dos sitios: ancho del rectángulo y texto -->
                    <svg width="500" height="30">
                        <rect x="0" y="5" width="<?php echo $anchoAzul; ?>" height="20" fill="blue" />
                        <text x="<?php echo $anchoAzul + 5; ?>" y="20" fill="black">
                            <?php echo $_SESSION['votos_azul']; ?>
                        </text>
                    </svg>
                </td>
            </tr>

            <!-- Opción 2: Naranja -->
            <tr>
                <td>
                    <button type="submit" name="accion" value="naranja"><img src="recursos/naranja.png"/></button>
                </td>
                <td>
                    <!-- SVG donde el número de sesión se usa en dos sitios: ancho del rectángulo y texto -->
                    <svg width="500" height="30">
                        <rect x="0" y="5" width="<?php echo $anchoNaranja; ?>" height="20" fill="orange" />
                        <text x="<?php echo $anchoNaranja + 5; ?>" y="20" fill="black">
                            <?php echo $_SESSION['votos_naranja']; ?>
                        </text>
                    </svg>
                </td>
            </tr>

            <!-- Espacio de separación -->
            <tr>
                <td colspan="2"><br></td>
            </tr>

            <!-- Botón Poner a cero -->
            <tr>
                <td colspan="2">
                    <button type="submit" name="accion" value="cero">Poner a cero</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
