<?php
    $dsn = "mysql:host=localhost;dbname=agendabd;charset=utf8mb4";

    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    try {
        $pdo = new PDO($dsn, "root", "", $opciones);
        // echo "Conexión establecida con éxito.";
    } catch (PDOException $e) {
        // En producción NUNCA mostramos e.getMessage() al usuario final por seguridad
        error_log("Error al acceder a la base de datos: " . $e->getMessage());
        echo "[ERROR CONEXIÓN]: Ha habido un error al conectarse a la base de datos.";
    }
?>