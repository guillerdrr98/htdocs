<?php
session_start();
require_once '../ConexionBD/funcionesBusqueda.php';

$ranking = obtenerRanking();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simón dice... — Estadísticas Globales</title>
</head>
<body>

    <div align="center">
        <h2>Simón dice... - Estadísticas Globales</h2>
        <p><?= $_SESSION['nom_usuario'] ?>, los resultados son:</p>

        <table border="1">
            <thead>
                <tr>
                    <th>Cód.</th>
                    <th>Nombre</th>
                    <th>Aciertos</th>
                    <th>Gráfica</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ranking)): ?>
                    <?php foreach ($ranking as $fila): 
                        // Ancho proporcional en CSS puro sin dependencias
                        $anchoBarra = max($fila['aciertos'] * 10, 5);
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fila['codigousu']); ?></td>
                            <td><?php echo htmlspecialchars($fila['nombre_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($fila['aciertos']); ?></td>
                            <td align="left" style="width: 220px;">
                                <div style="background-color: #0073e6; height: 12px; width: <?php echo $anchoBarra; ?>px;"></div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Todavía no hay registros de partidas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br>

        <a href="../ManejoPartida/solucion.php">Volver a jugar</a> | 
        <a href="../ManejoPartida/index.php">Salir</a>
    </div>

</body>
</html>