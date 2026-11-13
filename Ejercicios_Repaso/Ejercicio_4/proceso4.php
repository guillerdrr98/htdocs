<?php
    session_start();

    // Asegurar inicialización de las variables de sesión
    if (!isset($_SESSION['votos_azul'])) {
        $_SESSION['votos_azul'] = 0;
    }

    if (!isset($_SESSION['votos_naranja'])) {
        $_SESSION['votos_naranja'] = 0;
    }

    // Recoger el dato enviado por el formulario
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

        if ($accion === 'azul') {
            $_SESSION['votos_azul']++;
        } elseif ($accion === 'naranja') {
            $_SESSION['votos_naranja']++;
        } elseif ($accion === 'cero') {
            $_SESSION['votos_azul'] = 0;
            $_SESSION['votos_naranja'] = 0;
        }
    }

    // Redirigir a la página principal
    header('Location: ejercicio4.php');
    exit();
?>