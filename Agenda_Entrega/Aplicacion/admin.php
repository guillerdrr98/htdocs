<?php
    require_once 'seguridad.php';
    require_once '../ConexionBD/funcionesBusqueda.php';

    $msgError = "";
    $msgExito = "";

    $config = obtenerConfiguracion();
    $maxLote = $config['max_lote'];
    $numEmojis = $config['num_emojis'];
    $maxContactos = $config['max_contactos'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nuevoLote = (int) ($_POST['max_lote'] ?? 0);
        $nuevosEmojis = (int) ($_POST['num_emojis'] ?? 0);
        $nuevoTope = (int) ($_POST['max_contactos'] ?? 0);

        if (actualizarConfiguracion($nuevoLote, $nuevosEmojis, $nuevoTope)) {
            $maxLote = $nuevoLote;
            $numEmojis = $nuevosEmojis;
            $maxContactos = $nuevoTope;
            $msgExito = "Configuración guardada.";
        } else {
            $msgError = "No se pudo guardar la configuración.";
        }
    }

$usuarios = listarUsuariosConContactos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Agenda</title>
</head>
<body>
    <h1>Panel de Administración</h1>
    <p>
        Conectado como: <?= htmlspecialchars((string) $_SESSION['nom_usuario']) ?> (rol <?= htmlspecialchars((string) $_SESSION['rol']) ?>) |
        <a href="salir.php">Cerrar sesión</a>
    </p>

    <?php if ($msgError !== ""): ?>
        <p style="color: red;"><?= htmlspecialchars($msgError) ?></p>
    <?php endif; ?>

    <?php if ($msgExito !== ""): ?>
        <p style="color: green;"><?= htmlspecialchars($msgExito) ?></p>
    <?php endif; ?>

    <form action="admin.php" method="POST">
        <label for="max_lote">Contactos por lote (3-8):</label>
        <input type="number" id="max_lote" name="max_lote" value="<?= htmlspecialchars((string) $maxLote) ?>" min="3" max="8" required><br><br>

        <label for="num_emojis">Emojis disponibles (4-10):</label>
        <input type="number" id="num_emojis" name="num_emojis" value="<?= htmlspecialchars((string) $numEmojis) ?>" min="4" max="10" required><br><br>

        <label for="max_contactos">Máx. contactos por usuario (10-100):</label>
        <input type="number" id="max_contactos" name="max_contactos" value="<?= htmlspecialchars((string) $maxContactos) ?>" min="10" max="100" required><br><br>

        <button type="submit">Guardar configuración</button>
    </form>

    <h2>Usuarios registrados</h2>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Nombre</th>
                <th>Rol</th>
                <th>Contactos</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $u['codigo']) ?></td>
                        <td><?= htmlspecialchars((string) $u['nombre']) ?></td>
                        <td><?= htmlspecialchars((string) $u['rol']) ?></td>
                        <td><?= htmlspecialchars((string) $u['total_contactos']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>