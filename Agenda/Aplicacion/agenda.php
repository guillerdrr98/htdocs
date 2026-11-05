<?php
    require_once 'seguridad.php';
    require_once '../ConexionBD/funcionesBusqueda.php';
    require_once '../Funciones/funciones.php';

    // Requisito: No se puede entrar en agenda.php sin un lote iniciado en sesión
    if (!isset($_SESSION['emojis_lote']) || empty($_SESSION['emojis_lote'])) {
        header("Location: inicio.php");
        exit();
    }

    $erroresGenerales = [];
    $datosFormulario = [];
    $listaErroresPorBloque = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $datosFormulario = $_POST['contacto'] ?? [];
        $todoCorrecto = true;

        foreach ($_SESSION['emojis_lote'] as $i => $emoji) {
            $c = $datosFormulario[$i] ?? [];
            $erroresBloque = validarContacto($c);
            if (!empty($erroresBloque)) {
                $todoCorrecto = false;
                $listaErroresPorBloque[$i] = $erroresBloque;
            }
        }

        if ($todoCorrecto) {
            $numContactosLote = count($_SESSION['emojis_lote']);
        
            // Insertar el lote completo usando la transacción
            $exito = insertarLoteContactos($_SESSION['codigo'], $_SESSION['emojis_lote'], $datosFormulario);

            if ($exito) {
                // Guardamos el número de grabados para mostrarlos en grabado.php
                $_SESSION['ultimos_grabados'] = $numContactosLote;
            
                // Borramos el lote de la sesión para evitar duplicidades al recargar
                unset($_SESSION['emojis_lote']);
            
                header("Location: grabado.php");
                exit();
            } else {
                $erroresGenerales[] = "Hubo un error en la base de datos. No se pudo completar el grabado.";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda de Contactos - Grabar</title>
</head>
<body>
    <h2>AGENDA DE CONTACTOS</h2>
    <p>Usuario: <strong><?= htmlspecialchars($_SESSION['nom_usuario']) ?></strong></p>

    <?php if (!empty($erroresGenerales)): ?>
        <?php foreach ($erroresGenerales as $err): ?>
            <p><?= $err ?></p>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="agenda.php" method="POST">
        <?php foreach ($_SESSION['emojis_lote'] as $i => $emoji): ?>
            <?php 
                $valoresBloque = $datosFormulario[$i] ?? [];
                $erroresBloque = $listaErroresPorBloque[$i] ?? [];
                echo pintarFormularioContactos($i, $emoji, $valoresBloque, $erroresBloque);
            ?>
        <?php endforeach; ?>

        <br>
        <button type="submit">Grabar contactos</button>
    </form>
</body>
</html>