<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION['nom_usuario'], $_SESSION['rol'], $_SESSION['cod_usuario'])) {
        header("Location: ../Aplicacion/index.php");
        exit();
    }

    require_once '../ConexionBD/funcionesBusqueda.php';

    $codUsuario = (int) $_SESSION['cod_usuario'];
    $nomUsuario = (string) $_SESSION['nom_usuario'];
    $rol = (int) $_SESSION['rol'];

    $estadisticas = obtenerEstadisticasUsuarios();
    $rutaVolver = ($rol === 1) ? '../Aplicacion/admin.php' : '../Aplicacion/inicio.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Totales de Contactos - Agenda</title>
</head>
<body>
    <h1>AGENDA - Totales</h1>

    <p><?= htmlspecialchars($nomUsuario) ?>, estos son los contactos guardados:</p>

    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Cód.</th>
                <th>Nombre</th>
                <th>Cont.</th>
                <th>%</th>
                <th>Último alta</th>
                <th>Gráfica</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estadisticas as $u): ?>
                <?php
                $esActual = ((int) $u['codigo'] === $codUsuario);
                $porcentajeFmt = number_format((float) $u['porcentaje'], 1, ',', '.');
                $fechaFormateada = '&mdash;';
                if (!empty($u['ultimo_alta'])) {
                    $timestamp = strtotime((string) $u['ultimo_alta']);
                    if ($timestamp !== false) {
                        $fechaFormateada = date('d/m/Y', $timestamp);
                    }
                }
                $anchoBarra = (int) round((float) $u['porcentaje'] * 2);
                ?>
                <tr>
                    <td><?= $esActual ? '<strong>' . (int) $u['codigo'] . '</strong>' : (int) $u['codigo'] ?></td>
                    <td><?= $esActual ? '<strong>' . htmlspecialchars((string) $u['nombre']) . '</strong>' : htmlspecialchars((string) $u['nombre']) ?></td>
                    <td><?= $esActual ? '<strong>' . (int) $u['total_contactos'] . '</strong>' : (int) $u['total_contactos'] ?></td>
                    <td><?= $esActual ? '<strong>' . htmlspecialchars($porcentajeFmt) . '</strong>' : htmlspecialchars($porcentajeFmt) ?></td>
                    <td><?= $esActual ? '<strong>' . $fechaFormateada . '</strong>' : $fechaFormateada ?></td>
                    <td>
                        <?php if ($anchoBarra > 0): ?>
                            <progress max="200" value="<?= $anchoBarra ?>"></progress>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p>
        <a href="<?= htmlspecialchars($rutaVolver) ?>">Grabar más contactos</a>
        <a href="../Aplicacion/salir.php">Cerrar sesión</a>
    </p>
</body>
</html>