<?php
    /*var_dump($_FILES);*/
    $target_dir = "../destino_prueba/";
    $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
    $uploadOK = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $originalName = basename($_FILES["fileToUpload"]["name"]);

    //Comprobamos si es una imagen real o falsa
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if(file_exists($target_file)){
        echo "El fichero ya existe.";
        $uploadOK = 0;
    }

    if($check !== false){
        echo "El fichero es una imagen - ".$check["mime"].".<br>";
        $uploadOK = 1;
    }else{
        echo "El fichero no es una imagen.";
        $uploadOK = 0;
    }

    // Subida al servidor
    if ($uploadOK === 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "El archivo " . htmlspecialchars($originalName) . " se ha subido correctamente.";
        } else {
            echo "Ha ocurrido un error al subir el archivo.";
        }
    }

?>