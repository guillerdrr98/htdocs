<?php
    session_start();
    require 'funciones.php';

    $numero_circulos = $_SESSION['num_circulos'];
    $paleta = $_SESSION['paleta'];
    $solucion_texto = $_SESSION['combinacion_colores_texto'];
    $fondo_actual = $_SESSION['cookie_fondo'];

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
            header("Location: ../PantallasFinal/acierto.php");
        } else {
            header("Location: ../PantallasFinal/fallo.php");
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
<body style = 'background-color: <?=$fondo_actual?>'>
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
</body>
</html>