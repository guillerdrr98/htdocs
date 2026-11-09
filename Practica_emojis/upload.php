<?php
    $target_dir = "emojis/";

    // Verificamos si se ha seleccionado un fichero y si el campo se llama 'emoji'
    if (!isset($_FILES["emoji"]) || $_FILES["emoji"]["error"] === UPLOAD_ERR_NO_FILE) {
        $uploadOK = 0;
        $mensaje_error = "No has seleccionado ningún fichero.";
    } else {
        $target_file = $target_dir . basename($_FILES["emoji"]["name"]);
        $uploadOK = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $originalName = basename($_FILES["emoji"]["name"]);

        $mensajes_error = [];

        // 1. Comprobamos si es una imagen real
        $check = getimagesize($_FILES["emoji"]["tmp_name"]);
        if($check === false){
            $mensajes_error[] = "El fichero no es una imagen.";
            $uploadOK = 0;
        }

        // 2. Comprobamos la extensión (png, jpg, jpeg, gif o webp)
        $extensiones_permitidas = ['png', 'jpg', 'jpeg', 'gif', 'webp'];
        if (!in_array($imageFileType, $extensiones_permitidas)) {
            $mensajes_error[] = "Formato no válido. Solo png, jpg, jpeg, gif o webp.";
            $uploadOK = 0;
        }

        // 3. Comprobamos si el fichero ya existe
        /* MODIFICACIÓN 1: ELIMINAMOS ESTE BLOQUE PARA IMPLEMENTAR RENOMBRADO */
        /*if(file_exists($target_file)){
            $mensajes_error[] = "Ese emoji ya existe en la galería.";
            $uploadOK = 0;
        }*/

        // 4. Comprobamos el tamaño máximo (200 KB = 200 * 1024 bytes)
        $tamano_maximo = 200 * 1024;
        if ($_FILES["emoji"]["size"] > $tamano_maximo) {
            $mensajes_error[] = "El emoji es demasiado grande (máximo 200 KB).";
            $uploadOK = 0;
        }

        // Subida al servidor si todo es correcto
        /* MODIFICACIÓN 1: IMPLEMENTAMOS LA CREACIÓN DEL NUEVO NOMBRE */
        $subido_correctamente = false;
        if ($uploadOK === 1) {
            $nuevo_nombre = time() . "-" . $originalName;
            $target_file = $target_dir . $nuevo_nombre;

            if (move_uploaded_file($_FILES["emoji"]["tmp_name"], $target_file)) {
                $subido_correctamente = true;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Galería de emojis</h1>

    <?php if(isset($subido_correctamente) && $subido_correctamente): ?>
        <p>¡Emoji subido correctamente!</p>
    <?php endif; ?>

    <?php if (!empty($mensajes_error)): ?>
        <?php foreach ($mensajes_error as $error): ?>
            <p style="color: red;"><?= $error; ?></p>
        <?php endforeach; ?>
        <p>La galería no cambia: no se ha guardado nada</p>
    <?php endif; ?>

    <p><a href="index.html">Subir otro emoji</a></p>

    <hr>

    <h2>Galería</h2>
    <div>
        <?php
        // Mostramos los emojis que hay en la carpeta
        if (is_dir($target_dir)) {
            $ficheros = scandir($target_dir);
            foreach ($ficheros as $archivo) {
                if ($archivo !== '.' && $archivo !== '..') {
                    echo '<img src="' . $target_dir . $archivo . '" alt="' . $archivo . '" width="80">';
                }
            }
        }
        ?>
    </div>

</body>
</html>