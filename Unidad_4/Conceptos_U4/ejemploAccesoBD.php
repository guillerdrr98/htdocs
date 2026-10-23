<?php
    require 'conexion.php';
    require 'cierre.php';
    // Declaración de parámetros para acceder a la BBDD
    $pdo = "";
    $dsn = "";

    crearConexion($dsn, $pdo);

    try{
        // Consulta SELECT de prueba mapeando a la BBDD agenda
        $sql = "SELECT * FROM usuarios";
        $stmt = $pdo -> prepare($sql);

        // Ejecutar la sentencia
        $stmt -> execute();
        echo "<br>";

        // Obtener los resultados en un array asociativo
        while ($fila = $stmt->fetch()) {
            // htmlspecialchars evita inyecciones de código HTML/JavaScript (XSS)
            $codigo = htmlspecialchars($fila['Codigo']);
            $nombre = htmlspecialchars($fila['Nombre']);
            $clave = htmlspecialchars($fila['Clave']);
            $rol = htmlspecialchars($fila['Rol']);
            echo "Codigo: {$codigo} | Nombre: $nombre | Clave: $clave | Rol: $rol <br>";
        }
    }catch(PDOException $e){
        error_log("Error en SELECT: " . $e -> getMessage());
        echo "No se pudieron obtener los usuarios.";
    }finally{
        cierreConexion($stmt, $pdo);
    }
    
?>