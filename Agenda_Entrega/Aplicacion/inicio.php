<?php
    require_once 'seguridad.php';
    require_once '../ConexionBD/funcionesBusqueda.php';

    $codUsuario = (int) ($_SESSION['cod_usuario'] ?? 0);
    $nomUsuario = (string) ($_SESSION['nom_usuario'] ?? '');

    $config = obtenerConfiguracion();
    $maxLote = $config['max_lote'];
    $maxContactos = $config['max_contactos'];
    $totalActual = contarContactosUsuario($codUsuario);
    $restantes = max(0, $maxContactos - $totalActual);
    $limiteLote = min($maxLote, $restantes);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Agenda de Contactos</title>
</head>
<body>
    <h1>Agenda de Contactos</h1>
    <p>
        Usuario: <strong><?= htmlspecialchars($nomUsuario) ?></strong> |
        <a href="../Estadisticas/totales.php">Ver totales</a> |
        <a href="salir.php">Cerrar sesión</a>
    </p>

    <p>
        Contactos guardados: <strong><?= htmlspecialchars((string) $totalActual) ?></strong> /
        Máximo permitido: <strong><?= htmlspecialchars((string) $maxContactos) ?></strong>
    </p>

    <?php if ($limiteLote > 0): ?>
        <form action="agenda.php" method="POST">
            <label for="cantidad">¿Cuántos contactos quieres grabar en este lote? (1 - <?= htmlspecialchars((string) $limiteLote) ?>):</label>
            <input type="number" id="cantidad" name="cantidad" min="1" max="<?= htmlspecialchars((string) $limiteLote) ?>" value="1" required><br><br>
            <button type="submit">Continuar</button>
        </form>
    <?php else: ?>
        <p style="color: red; font-weight: bold;">
            Has alcanzado el límite máximo de contactos permitidos (<?= htmlspecialchars((string) $maxContactos) ?>).
        </p>
    <?php endif; ?>
</body>
</html>