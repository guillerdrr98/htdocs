<?php
    require_once 'seguridad.php';
    require_once '../ConexionBD/funcionesBusqueda.php';

    // Obtener los datos agregados de todos los usuarios
    $usuarios = obtenerTotalesUsuarios();

    // Calcular el total general de contactos y el máximo para la barra proporcional
    $totalAgenda = 0;
    $maxContactosUsuario = 0;
    foreach ($usuarios as $u) {
        $totalAgenda += $u['total_contactos'];
        if ($u['total_contactos'] > $maxContactosUsuario) {
            $maxContactosUsuario = $u['total_contactos'];
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Total de Contactos</title>
</head>
<body>
    <h2>Total de Contactos</h2>
    
    <p>
        Usuario conectado: <strong><?= htmlspecialchars($_SESSION['nom_usuario']) ?></strong> | 
        <a href="inicio.php">Grabar más contactos</a> | 
        <a href="salir.php">Cerrar sesión</a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Contactos</th>
                <th>% sobre el total</th>
                <th>Último alta</th>
                <th>Gráfica</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $u): ?>
                    <?php 
                        // Calcular el porcentaje sobre el total de la agenda con 1 decimal
                        $porcentaje = ($totalAgenda > 0) ? ($u['total_contactos'] / $totalAgenda) * 100 : 0;
                        
                        // Comprobar si la fila corresponde al usuario conectado actual
                        $esUsuarioActual = ($u['codigo'] == $_SESSION['codigo']);
                        
                        // Calcular el ancho proporcional de la barra CSS
                        $anchoBarra = ($maxContactosUsuario > 0) ? ($u['total_contactos'] / $maxContactosUsuario) * 100 : 0;
                    ?>
                    <tr <?= $esUsuarioActual ? 'style="background-color: #ffeb3b;"' : '' ?>>
                        <td><?= htmlspecialchars($u['codigo']) ?></td>
                        <td><?= htmlspecialchars($u['nombre']) ?></td>
                        <td><?= htmlspecialchars($u['total_contactos']) ?></td>
                        <td><?= number_format($porcentaje, 1, ',', '.') ?>%</td>
                        <td><?= htmlspecialchars($u['ultimo_contacto'] ?? 'Ninguna') ?></td>
                        <td>
                            <div style="background-color: #ddd; width: 120px; height: 14px;">
                                <div style="background-color: #4CAF50; width: <?= $anchoBarra ?>%; height: 100%;"></div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>