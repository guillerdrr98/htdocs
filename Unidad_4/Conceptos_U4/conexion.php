<?php
    function crearConexion($dsn, &$pdo){
        $dsn = "mysql:host=localhost;dbname=agenda;charset=utf8mb4";
        try{
            $pdo = new PDO($dsn, "root", "");
            echo "Conexión establecida con éxito a la base de datos 'agenda'.";
        }catch(PDOException $e){
            // En producción NUNCA debemos mostrar e.getMessage() directamente 
            // al usuario final por SEGURIDAD
            error_log("Error al acceder a la base de datos: ". $e -> getMessage());
            echo "[ERROR CONEXIÓN]: Ha habido un error al conectarse a la base de datos.";
        }
    }
?>