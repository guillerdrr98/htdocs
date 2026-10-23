<?php
    // Ponemos & para que se trabaje con los stmn y pdo del archivo original y no con copias creadas
    function cierreConexion(&$stmt, &$pdo){
        $stmt = null; // Liberamos el cursor
        $pdo = null; // Cerramos la conexión
        echo "Cerrada conexión con la base de datos.";
    }
?>