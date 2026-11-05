<?php
    require_once 'seguridad.php';
    require_once '../ConexionBD/funcionesBusqueda.php';
    require_once '../Funciones/funciones.php';

    // Obtener la configuración actual utilizando la función de búsqueda
    $config = obtenerConfiguracion();

    $maxLote = $config['max_lote'];
    $maxContactos = $config['max_contactos'];
    $emojisDisponibles = emojisDisponibles($config['num_emojis']);

    // Inicializar la sesión del lote de emojis si no existe
    if (!isset($_SESSION['emojis_lote'])) {
        $_SESSION['emojis_lote'] = [emojiAleatorio($emojisDisponibles)];
    }

    // Procesar la acción de incrementar
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['incrementar'])) {
            if (count($_SESSION['emojis_lote']) < $maxLote) {
                $_SESSION['emojis_lote'][] = emojiAleatorio($emojisDisponibles);
            }
        } elseif (isset($_POST['grabar'])) {
            header("Location: agenda.php");
            exit();
        }

        // Comprobar mediante función si se ha llegado al tope del lote o al máximo de contactos permitidos
        $contactosActuales = contarContactosUsuario($_SESSION['codigo']);

        if (count($_SESSION['emojis_lote']) >= $maxLote || ($contactosActuales + count($_SESSION['emojis_lote'])) >= $maxContactos) {
            header("Location: agenda.php");
            exit();
        }
    }

    $numEmojisLote = count($_SESSION['emojis_lote']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Agenda de Contactos</title>
</head>
<body>
    <h2>AGENDA DE CONTACTOS</h2>
    <p>Usuario: <strong><?= htmlspecialchars($_SESSION['nom_usuario']) ?></strong> · Contactos a grabar: <strong><?= $numEmojisLote ?></strong></p>

    <div style="font-size: 30px; margin: 20px 0;">
        <?php foreach ($_SESSION['emojis_lote'] as $e): ?>
            <span><?= $e ?></span>
        <?php endforeach; ?>
    </div>

    <form action="inicio.php" method="POST">
        <?php if ($numEmojisLote < $maxLote): ?>
            <button type="submit" name="incrementar">INCREMENTAR</button>
        <?php endif; ?>
        <button type="submit" name="grabar">GRABAR</button>
    </form>
</body>
</html>