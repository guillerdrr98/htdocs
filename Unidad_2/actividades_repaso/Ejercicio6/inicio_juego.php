<?php
    session_start();
    require 'funciones.php';

    // Accedemos a las variables de sesión
    $solucion_negro = $_SESSION['svg_negro'];
    $numero_circulos = $_SESSION['num_circulos'];
    $paleta_colores_texto = $_SESSION['paleta_texto'];
    $paleta_hex = $_SESSION['colores_hex'];
    $solucion_texto = $_SESSION['combinacion_colores_texto'];

    $num_colores = count($paleta_colores_texto);
    $juego_finalizado = false;
    $mensaje_resultado = "";

    // Inicializamos las variables de la partida si no existen
    if (!isset($_SESSION['jugada'])) {
        $_SESSION['jugada'] = array();
    }
    if (!isset($_SESSION['pulsaciones'])) {
        $_SESSION['pulsaciones'] = 0;
    }

    // Procesar la pulsación del botón
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['color_elegido']) && $_SESSION['pulsaciones'] < $numero_circulos) {
            $color_seleccionado = $_POST['color_elegido'];
            
            $_SESSION['jugada'][] = $color_seleccionado;
            $_SESSION['pulsaciones']++;
        }
    }

    // Comprobar si se ha alcanzado el número total de círculos
    if ($_SESSION['pulsaciones'] === $numero_circulos) {
        $juego_finalizado = true;
    
        // Comparación estricta de ambos arrays (mismos colores y mismo orden)
        if ($_SESSION['jugada'] === $solucion_texto) {
            $mensaje_resultado = "<h3 style='color: green;'>¡Enhorabuena! Has ganado</h3>";
        } else {
            $mensaje_resultado = "<h3 style='color: red;'>¡Has perdido! La combinación no es correcta.</h3>";
        }
    }

    // Generar el SVG dinámico según las jugadas registradas hasta el momento
    $svg_actual = generar_svg_juego($_SESSION['jugada'], $numero_circulos, $paleta_colores_texto, $paleta_hex);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simón dice...</title>
</head>
<body>
    <h2>Progreso de la partida (Pulsación <?= $_SESSION['pulsaciones'] ?> de <?= $numero_circulos ?>):</h2>

    <div>
        <!-- CORRECCIÓN 1: Imprimimos $svg_actual para que se vean los círculos pintados -->
        <?= $svg_actual ?>

        <form method="POST">
            <?php
                for ($i = 0; $i < $num_colores; $i++) {
                    // Desactivar botones si la partida ya ha finalizado
                    $disabled = $juego_finalizado ? 'disabled' : '';
                    echo '<button name="color_elegido" value="' . $paleta_colores_texto[$i] . '" style="background-color: ' . $paleta_hex[$i] . '; color: black; margin: 5px;" type="submit" ' . $disabled . '>'. $paleta_colores_texto[$i]. '</button>';
                }
            ?>
        </form>
    </div>

    <?php
        if ($juego_finalizado) {
            echo "<br>";
            echo $mensaje_resultado;
            echo "<p><strong>Solución correcta: </strong>" . implode(", ", $solucion_texto) . "</p>";
            echo '<a href="index.php"><button>Jugar otra vez</button></a>';

            // CORRECCIÓN 2: Limpiamos las variables de la partida terminada en la sesión
            unset($_SESSION['jugada']);
            unset($_SESSION['pulsaciones']);
        }
    ?>
</body>
</html>