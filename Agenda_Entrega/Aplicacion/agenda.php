<?php
    require_once 'seguridad.php';
    require_once '../ConexionBD/funcionesBusqueda.php';
    require_once 'funciones.php';

    $config = obtenerConfiguracion();
    $maxLote = $config['max_lote'];
    $numEmojis = $config['num_emojis'];

    $cantidad = (int) ($_POST['cantidad'] ?? 1);
    if ($cantidad < 1) {
        $cantidad = 1;
    } elseif ($cantidad > $maxLote) {
        $cantidad = $maxLote;
    }

    $emojis = obtenerEmojis($numEmojis);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de Contactos - Agenda</title>
</head>
<body>
    <h1>Nuevo lote de contactos</h1>
    <p>
        Usuario: <strong><?= htmlspecialchars((string) $_SESSION['nom_usuario']) ?></strong> |
        <a href="inicio.php">Volver a inicio</a> |
        <a href="salir.php">Cerrar sesión</a>
    </p>

    <form action="grabado.php" method="POST">
        <?php for ($i = 0; $i < $cantidad; $i++): ?>
            <?php
            $archivoAsignado = $emojis[$i % count($emojis)];
            $valorEmoji = pathinfo($archivoAsignado, PATHINFO_FILENAME);
            ?>
            <fieldset>
                <legend>Contacto <?= $i + 1 ?></legend>

                <span>Emoji asignado:</span>
                <?= pintarEmojis($emojis, $i) ?>
                <input type="hidden" name="contactos[<?= $i ?>][emoji]" value="<?= htmlspecialchars($valorEmoji, ENT_QUOTES, 'UTF-8') ?>"><br><br>

                <label for="nombre_<?= $i ?>">Nombre:</label>
                <input type="text" id="nombre_<?= $i ?>" name="contactos[<?= $i ?>][nombre]" maxlength="30" required><br><br>

                <label for="apellidos_<?= $i ?>">Apellidos:</label>
                <input type="text" id="apellidos_<?= $i ?>" name="contactos[<?= $i ?>][apellidos]" maxlength="50" required><br><br>

                <label for="telefono_<?= $i ?>">Teléfono (9 dígitos):</label>
                <input type="text" id="telefono_<?= $i ?>" name="contactos[<?= $i ?>][telefono]" pattern="\d{9}" maxlength="9" required><br><br>

                <label for="email_<?= $i ?>">Email:</label>
                <input type="email" id="email_<?= $i ?>" name="contactos[<?= $i ?>][email]" maxlength="80" required>
            </fieldset>
            <br>
        <?php endfor; ?>

        <button type="submit">Grabar</button>
    </form>
</body>
</html>