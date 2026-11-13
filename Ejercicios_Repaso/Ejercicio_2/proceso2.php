<?php
    session_start();

    // Asegurar inicialización de la sesión
    if (!isset($_SESSION['posicion'])) {
        $_SESSION['posicion'] = 0;
    }

    // Comprobar y procesar la acción recibida
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'izquierda') {
            $_SESSION['posicion'] -= 20;
        } elseif ($accion === 'derecha') {
            $_SESSION['posicion'] += 20;
        } elseif ($accion === 'centro') {
            $_SESSION['posicion'] = 0;
        }

        // Comprobar si el punto sale de los límites (-300 a 300) para que aparezca en el lado opuesto
        if ($_SESSION['posicion'] > 300) {
            $_SESSION['posicion'] = -300;
        } elseif ($_SESSION['posicion'] < -300) {
            $_SESSION['posicion'] = 300;
        }
    }

    header('Location: ejercicio2.php');
    exit();
?>