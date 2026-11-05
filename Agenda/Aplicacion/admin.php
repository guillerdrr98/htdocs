<?php
    require_once 'seguridad.php';
    require_once '../ConexionBD/funcionesBusqueda.php';

    $mensaje = "";
    $error = "";

    // 1. Procesar el formulario de actualización
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $max_lote = filter_input(INPUT_POST, 'max_lote', FILTER_VALIDATE_INT);
        $num_emojis = filter_input(INPUT_POST, 'num_emojis', FILTER_VALIDATE_INT);
        $max_contactos = filter_input(INPUT_POST, 'max_contactos', FILTER_VALIDATE_INT);

        // Validación estricta en el servidor por seguridad
        if (
            $max_lote === false || $max_lote < 3 || $max_lote > 8 ||
            $num_emojis === false || $num_emojis < 4 || $num_emojis > 10 ||
            $max_contactos === false || $max_contactos < 10 || $max_contactos > 100
        ) {
            $error = "Error: Todos los valores deben ser enteros y estar dentro de sus rangos permitidos.";
        } else {
            if (actualizarConfiguracion($max_lote, $num_emojis, $max_contactos)) {
                $mensaje = "¡Configuración actualizada correctamente!";
            } else {
                $error = "No se pudo actualizar la configuración debido a un error en la base de datos.";
            }
        }
    }

    // 2. Obtener la configuración actual mediante función
    $config = obtenerConfiguracion();

    // 3. Obtener la lista de usuarios y sus contactos mediante función
    $usuarios = obtenerUsuariosConContactos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
</head>
<body>
    <h2>Panel de Administración</h2>
    
    <p>
        Conectado como: <strong><?= htmlspecialchars($_SESSION['nom_usuario']) ?></strong> (rol <?= $_SESSION['rol'] ?>) | 
        <a href="salir.php">Cerrar sesión</a>
    </p>

    <?php if ($mensaje != ""): ?>
        <p><?= $mensaje ?></p>
    <?php endif; ?>

    <?php if ($error != ""): ?>
        <p><?= $error ?></p>
    <?php endif; ?>

    <!-- Formulario de configuración simple -->
    <form action="admin.php" method="POST" autocomplete="off">
        <label for="max_lote">Contactos por lote (3-8):</label>
        <input type="number" id="max_lote" name="max_lote" value="<?= htmlspecialchars($config['max_lote'] ?? 5) ?>" min="3" max="8" required><br><br>

        <label for="num_emojis">Emojis disponibles (4-10):</label>
        <input type="number" id="num_emojis" name="num_emojis" value="<?= htmlspecialchars($config['num_emojis'] ?? 6) ?>" min="4" max="10" required><br><br>

        <label for="max_contactos">Máx. contactos por usuario (10-100):</label>
        <input type="number" id="max_contactos" name="max_contactos" value="<?= htmlspecialchars($config['max_contactos'] ?? 50) ?>" min="10" max="100" required><br><br>
    
        <button type="submit">Guardar configuración</button>
    </form>

    <br>

    <!-- Tabla de usuarios simple -->
    <table>
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
                <?php foreach ($usuarios as $usu): ?>
                    <tr>
                        <td><?= htmlspecialchars($usu['codigo']) ?></td>
                        <td><?= htmlspecialchars($usu['nombre']) ?></td>
                        <td><?= htmlspecialchars($usu['rol']) ?></td>
                        <td><?= htmlspecialchars($usu['total_contactos']) ?></td>
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