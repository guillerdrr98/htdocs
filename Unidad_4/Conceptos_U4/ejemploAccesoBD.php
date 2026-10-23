<?php
    // Declaración de parámetros para acceder a la BBDD
    $host = 'localhost';
    $dbname = 'agenda';
    $user = 'root';
    $password= '';

    //Construccion del DSN (Data Source Name)
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

    try{
        $pdo = new PDO($dsn, $user, $password);
        echo "Conexión establecida con éxito a la base de datos '$dbname'.";
    }catch(PDOException $e){
        // En producción NUNCA debemos mostrar e.getMessage() directamente 
        // al usuario final por SEGURIDAD
        echo "[ERROR CONEXIÓN]: Ha habido un error al conectarse a la base de datos.";
    }

    try{
        // Consulta SELECT de prueba mapeando a la BBDD agenda
        $sql = "SELECT * FROM usuarios";
        $stmt = $pdo -> prepare($sql);

        // Ejecutar la sentencia
        $stmt->execute();
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
        error_log("Error en SELECT: " . $e->getMessage());
        echo "No se pudieron obtener los alumnos.";
    }finally{
        $stmt = null; // Liberamos el cursor
        $pdo = null; // Cerramos la conexión
    }
    
?>