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

    // Consulta SELECT de prueba mapeando a la BBDD agenda
    $sql = "SELECT * FROM usuarios";
    $stmt = $pdo -> prepare($sql);

    // Ejecutar la sentencia
    $stmt->execute();

    // Obtener los resultados en un array asociativo
    $usuarios = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    echo "<br>";

    // Imprimir el resultado para verificarlo
    foreach ($usuarios as $usuario) {
    echo "Codigo: " . $usuario['Codigo'] . " - Nombre: " . $usuario['Nombre'] . 
    " - Clave: " . $usuario['Clave'] . " - Rol: " . $usuario['Rol'] . "<br>";
}
?>