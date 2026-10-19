<?php
    session_start();
    require 'funciones.php';

    $numero_circulos = $_SESSION['num_circulos'];
    $paleta = $_SESSION['paleta'];
    $solucion_texto = $_SESSION['combinacion_colores_texto'];

    $juego_finalizado = false;
    $mensaje_resultado = "";

    // Procesar pulsación de botón
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['color_elegido'])) {
        if (($_SESSION['pulsaciones']) < $numero_circulos) {
            $_SESSION['jugada'][] = $_POST['color_elegido'];
            $_SESSION['pulsaciones']++;
        }
    }else{
        $_SESSION['jugada'] = [];
        $_SESSION['pulsaciones'] = 0;
    }

    $jugada = $_SESSION['jugada'];
    $pulsaciones = $_SESSION['pulsaciones'];

    // Comprobar fin de partida
    if ($pulsaciones === $numero_circulos) {
        $juego_finalizado = true;
        if ($jugada === $solucion_texto) {
            $mensaje_resultado = "<h3 style='color: green;'>¡Enhorabuena! Has ganado</h3>";
        } else {
            $mensaje_resultado = "<h3 style='color: red;'>¡Has perdido! La combinación no es correcta.</h3>" .
            "<p><strong>Solución correcta: </strong>" . implode(", ", $solucion_texto) . "</p>";
        }
    }

    $comb_actual = actualizar_juego($jugada, $numero_circulos, $paleta);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simón dice... - Partida</title>
</head>
<body>
    <h2>Progreso de la partida (Pulsación <?= $pulsaciones ?> de <?= $numero_circulos ?>):</h2>

    <div>
        <?= $comb_actual ?>

        <form method="POST">
            <?php
                foreach ($paleta as $texto => $hex) {
                    $disabled = $juego_finalizado ? 'disabled' : '';
                    echo '<button name="color_elegido" value="' . $texto . '" style="background-color: ' . $hex . '; 
                    color: black; margin: 5px;" type="submit" ' . $disabled . '>' . $texto . '</button>';
                }
            ?>
        </form>
    </div>

    <?php if ($juego_finalizado): ?>
        <br>
        <?= $mensaje_resultado ?>
        <a href="index.php"><button>Jugar otra vez</button></a>
    <?php endif; ?>
</body>
</html>