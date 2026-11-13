<?php
    session_start();

    if (!isset($_SESSION['x'])) {
        $_SESSION['x'] = 0;
    }

    if (!isset($_SESSION['y'])) {
        $_SESSION['y'] = 0;
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'arriba') {
            $_SESSION['y'] += 20;
        } elseif ($accion === 'abajo') {
            $_SESSION['y'] -= 20;
        } elseif ($accion === 'izquierda') {
            $_SESSION['x'] -= 20;
        } elseif ($accion === 'derecha') {
            $_SESSION['x'] += 20;
        } elseif ($accion === 'centro') {
            $_SESSION['x'] = 0;
            $_SESSION['y'] = 0;
        }

        // Comprobar límites para el eje X (-200 a 200) con efecto bucle
        if ($_SESSION['x'] > 200) {
            $_SESSION['x'] = -200;
        } elseif ($_SESSION['x'] < -200) {
            $_SESSION['x'] = 200;
        }

        // Comprobar límites para el eje Y (-200 a 200) con efecto bucle
        if ($_SESSION['y'] > 200) {
            $_SESSION['y'] = -200;
        } elseif ($_SESSION['y'] < -200) {
            $_SESSION['y'] = 200;
        }
    }

    header('Location: ejercicio3.php');
    exit();
?>