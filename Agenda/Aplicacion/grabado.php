<?php
    require_once 'seguridad.php';
    require_once '../ConexionBD/funcionesBusqueda.php';

    // Si no hay constancia de un grabado reciente, redirigimos al inicio
    if (!isset($_SESSION['ultimos_grabados'])) {
        header("Location: inicio.php");
        exit();
    }

    $numGrabadosLote = $_SESSION['ultimos_grabados'];
    $totalContactosAgenda = contarContactosUsuario($_SESSION['codigo']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto Grabado</title>
</head>
<body>
    <h2>AGENDA DE CONTACTOS — Resultado</h2>
    
    <p>Usuario conectado: <strong><?= htmlspecialchars($_SESSION['nom_usuario']) ?></strong></p>
    <p>Contactos grabados en este lote: <strong><?= $numGrabadosLote ?></strong></p>
    <p>Total de contactos en su agenda: <strong><?= $totalContactosAgenda ?></strong></p>

    <br>

    <ul>
        <li><a href="inicio.php">Grabar más contactos</a></li>
        <li><a href="totales.php">Ver totales</a></li>
        <li><a href="salir.php">Cerrar sesión</a></li>
    </ul>
</body>
</html>