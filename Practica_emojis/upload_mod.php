<?php
    $target_dir = "emojis/";
    $mensajes_error = [];
    $subidos_correctamente = 0;

    // MODIFICACIÓN: LÓGICA PARA BORRAR UN EMOJI MEDIANTE POST
    if (isset($_POST['archivo_borrar'])) {
        $archivo_a_borrar = basename($_POST['archivo_borrar']);
        $ruta_completa = $target_dir . $archivo_a_borrar;
        
        if (file_exists($ruta_completa)) {
            unlink($ruta_completa);
            $mensaje_borrado = "Emoji borrado correctamente.";
        }
    }

    // 1. Comprobar si se ha enviado el formulario y si hay ficheros seleccionados
    if (!isset($_FILES["emoji"]) || empty($_FILES["emoji"]["name"][0]) || $_FILES["emoji"]["error"][0] === UPLOAD_ERR_NO_FILE) {
        $mensajes_error[] = "No has seleccionado ningún fichero.";
    } else {
        // Recorremos cada archivo recibido en el array múltiple
        foreach ($_FILES["emoji"]["name"] as $i => $nombre_original) {
            $uploadOK = 1;
            $originalName = basename($nombre_original);
            $imageFileType = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

            // 2. Comprobar si es una imagen real
            $check = @getimagesize($_FILES["emoji"]["tmp_name"][$i]);
            if ($check === false) {
                $mensajes_error[] = "El fichero '$originalName' no es una imagen.";
                $uploadOK = 0;
            }

            // 3. Comprobar la extensión válida
            $extensiones_permitidas = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
            if (!in_array($imageFileType, $extensiones_permitidas)) {
                $mensajes_error[] = "Formato no válido para '$originalName'. Solo png, jpg, jpeg, gif o webp.";
                $uploadOK = 0;
            }

            // 4. Comprobar el tamaño máximo (200 KB = 200 * 1024 bytes)
            $tamano_maximo = 200 * 1024;
            if ($_FILES["emoji"]["size"][$i] > $tamano_maximo) {
                $mensajes_error[] = "El emoji '$originalName' es demasiado grande (máximo 200 KB).";
                $uploadOK = 0;
            }

            // 5. Comprobar el límite máximo de emojis en la galería (Nivel 1)
            $max_emojis = 10;
            if (is_dir($target_dir)) {
                $ficheros_actuales = array_diff(scandir($target_dir), ['.', '..']);
                if (count($ficheros_actuales) >= $max_emojis) {
                    $mensajes_error[] = "La galería está llena (máximo $max_emojis emojis). No se pudo subir '$originalName'.";
                    $uploadOK = 0;
                    break; // Paramos el bucle si se alcanza el límite
                }
            }

            // 6. Si pasa las validaciones, guardamos renombrando con la hora (Nivel 1 - evitar duplicados)
            if ($uploadOK === 1) {
                $nuevo_nombre = time() . "_" . $i . "_" . $originalName;
                $target_file = $target_dir . $nuevo_nombre;

                if (move_uploaded_file($_FILES["emoji"]["tmp_name"][$i], $target_file)) {
                    $subidos_correctamente++;
                } else {
                    $mensajes_error[] = "Ha ocurrido un error al subir el archivo '$originalName'.";
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Galería de emojis</title>
</head>
<body>

    <h1>Galería de emojis</h1>

    <?php if ($subidos_correctamente > 0): ?>
        <p>¡Se han subido <?= $subidos_correctamente; ?> emoji(s) correctamente!</p>
    <?php endif; ?>

    <?php if (!empty($mensajes_error)): ?>
        <?php foreach ($mensajes_error as $error): ?>
            <p><?= $error; ?></p>
        <?php endforeach; ?>
        <?php if (isset($mensaje_borrado)): ?>
            <p><?= $mensaje_borrado; ?></p>
        <?php endif; ?>
        <?php if ($subidos_correctamente === 0): ?>
            <p>La galería no cambia: no se ha guardado nada</p>
        <?php endif; ?>
    <?php endif; ?>

    <p><a href="index.html">Subir otro emoji</a></p>

    <hr>

    <h2>Galería</h2>
    <div>
        <?php
        // MODIFICACIÓN: MOSTRAR CADA IMAGEN CON UN FORMULARIO DE BORRADO (POST)
        if (is_dir($target_dir)) {
            $ficheros = scandir($target_dir);
            foreach ($ficheros as $archivo) {
                if ($archivo !== '.' && $archivo !== '..') {
                    echo '<div style="display: inline-block; margin: 10px; text-align: center;">';
                    echo '<img src="' . $target_dir . $archivo . '" alt="' . $archivo . '" width="80"><br>';
                    
                    // Mini formulario POST para borrar sin usar parámetros en la URL (?borrar=...)
                    echo '<form action="upload_mod.php" method="POST" style="margin-top: 5px;">';
                    echo '<input type="hidden" name="archivo_borrar" value="' . $archivo . '">';
                    echo '<button type="submit">Borrar</button>';
                    echo '</form>';
                    
                    echo '</div>';
                }
            }
        }
        ?>
    </div>

</body>
</html>