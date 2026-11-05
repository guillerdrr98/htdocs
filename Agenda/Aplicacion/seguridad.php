<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 1. Si no hay sesión, redirigir a index.php
    if (!isset($_SESSION['nom_usuario']) || !isset($_SESSION['rol'])) {
        header("Location: index.php");
        exit();
    }

    // 2. Control de redirecciones según rol e intento de acceso
    $paginaActual = basename($_SERVER['PHP_SELF']);

    // Si un administrador (rol 1) intenta entrar a secciones exclusivas de grabación de contactos de usuario
    if ($_SESSION['rol'] == 1 && $paginaActual === 'grabar.php') {
        header("Location: admin.php");
        exit();
    }

    // Si un usuario normal (rol 0) intenta entrar al panel de administración
    if ($_SESSION['rol'] == 0 && ($paginaActual === 'admin.php' || $paginaActual === 'config.php')) {
        header("Location: inicio.php");
        exit();
    }
?>