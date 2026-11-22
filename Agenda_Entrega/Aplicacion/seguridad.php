<?php

    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // 1. Si no hay sesión iniciada, redirige a index.php
    if (!isset($_SESSION['nom_usuario'], $_SESSION['rol'])) {
        header("Location: index.php");
        exit();
    }

    $rolActual = (int) $_SESSION['rol'];
    $paginaActual = basename($_SERVER['PHP_SELF']);
    $paginasGrabado = ['inicio.php', 'agenda.php', 'grabado.php'];

    // 2. Si un usuario con rol 1 intenta acceder a páginas de grabar contactos, redirige a admin.php
    if ($rolActual === 1 && in_array($paginaActual, $paginasGrabado, true)) {
        header("Location: admin.php");
        exit();
    }

    // 3. Si un usuario con rol 0 intenta acceder al panel de administración, redirige a inicio.php
    if ($rolActual === 0 && $paginaActual === 'admin.php') {
        header("Location: inicio.php");
        exit();
    }
?>