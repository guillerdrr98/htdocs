<?php
    require_once 'seguridad.php';
    require_once '../ConexionBD/funcionesBusqueda.php';

    $codUsuario = (int) ($_SESSION['cod_usuario'] ?? 0);
    $nomUsuario = (string) ($_SESSION['nom_usuario'] ?? '');

    $config = obtenerConfiguracion();
    $maxContactos = $config['max_contactos'];
    $totalPrevio = contarContactosUsuario($codUsuario);
    $huecosDisponibles = max(0, $maxContactos - $totalPrevio);

    $contactosRecibidos = $_POST['contactos'] ?? [];
    $grabados = [];
    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !is_array($contactosRecibidos) || empty($contactosRecibidos)) {
        $errores[] = "No se han recibido contactos para grabar.";
    } elseif ($huecosDisponibles <= 0) {
        $errores[] = "Ya has alcanzado el límite máximo de contactos permitidos (" . $maxContactos . ").";
    } else {
        $aProcesar = array_slice($contactosRecibidos, 0, $huecosDisponibles);

        foreach ($aProcesar as $indice => $datos) {
            $contacto = [
                'nombre' => trim((string) ($datos['nombre'] ?? '')),
                'apellidos' => trim((string) ($datos['apellidos'] ?? '')),
                'telefono' => trim((string) ($datos['telefono'] ?? '')),
                'email' => trim((string) ($datos['email'] ?? '')),
                'emoji' => trim((string) ($datos['emoji'] ?? 'emoji1')),
            ];

            if ($contacto['nombre'] === '' || $contacto['apellidos'] === '' ||
                $contacto['telefono'] === '' || $contacto['email'] === '') {
                $errores[] = "Contacto " . ($indice + 1) . ": faltan campos obligatorios.";
                continue;
            }

            if (insertarContacto($codUsuario, $contacto)) {
                $grabados[] = $contacto;
            } else {
                $errores[] = "Contacto " . ($indice + 1) . ": no se pudo guardar en la base de datos.";
            }
        }

        if (count($contactosRecibidos) > $huecosDisponibles) {
            $errores[] = "Solo se han podido grabar " . count($aProcesar) . " contacto(s) por el límite máximo de " . $maxContactos . ".";
        }
    }

    $totalActual = contarContactosUsuario($codUsuario);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Grabación de Contactos - Agenda</title>
</head>
<body>
    <h1>AGENDA DE CONTACTOS</h1>

    <p>Usuario: <strong><?= htmlspecialchars($nomUsuario) ?></strong></p>

    <?php if (!empty($errores)): ?>
        <div>
            <?php foreach ($errores as $err): ?>
                <p><?= htmlspecialchars($err) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <p>
        Se han grabado <strong><?= count($grabados) ?></strong> contactos en tu agenda
        <?php foreach ($grabados as $c): ?>
            <?php $imgEmoji = htmlspecialchars($c['emoji'] . '.png', ENT_QUOTES, 'UTF-8'); ?>
            <img src="../imagenes/<?= $imgEmoji ?>" alt="<?= htmlspecialchars($c['emoji']) ?>" width="22" height="22">
        <?php endforeach; ?>
    </p>

    <p>Tu agenda tiene ahora <strong><?= $totalActual ?></strong> contactos.</p>

    <p>
        <a href="inicio.php">Grabar más contactos</a>
        <a href="totales.php">Ver totales</a>
        <a href="salir.php">Cerrar sesión</a>
    </p>
</body>
</html>