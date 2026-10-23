<?php
    require_once 'conexion.php';

    $codigoNuevo = 5;
    $nombreNuevo = 'pepito';
    $claveNueva = 'pepito';
    $rolNuevo = 0;

    try{
        // Consulta SELECT de prueba mapeando a la BBDD agenda
        $sql = "INSERT INTO usuario (codigo, nombre, clave, rol) VALUES (:cod, :nom, :cla, :rol)";
        $stmt = $pdo -> prepare($sql);

        // Ejecutar la sentencia
        $stmt -> execute([
            ':cod' => $codigoNuevo,
            ':nom' => $nombreNuevo,
            ':cla' => $claveNueva,
            ':rol' => $rolNuevo
        ]);

        $afectados = $stmt->rowCount();
        echo "Usuario insertado con éxito en la base de datos (Filas afectadas: ".$afectados.")";
    }catch(PDOException $e){
        error_log("Error en SELECT: " . $e -> getMessage());
        echo "No se pudieron obtener los usuarios.";
    }finally{
        require_once 'cierre.php';
    }
?>