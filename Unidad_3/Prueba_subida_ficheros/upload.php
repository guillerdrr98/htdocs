<?php
    /*var_dump($_FILES);*/
    $target_dir = "uploads/";
    $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
    $uploadOK = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    //Comprobamos si es una imagen real o falsa
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if(file_exists($target_file)){
        echo "El fichero ya existe.";
        $uploadOK = 0;
    }

    if($check !== false){
        echo "El fichero es una imagen - ".$check["mime"].".";
        $uploadOK = 1;
    }else{
        echo "El fichero no es una imagen.";
        $uploadOK = 0;
    }

?>