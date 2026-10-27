<?php
    function verificarUsuPass($usuario, $pass){
        require_once 'conexion.php';
        try{
            $sql = "SELECT * FROM usuarios WHERE Nombre = :nom";
            $stmt = $pdo -> prepare($sql);

            $stmt -> execute([
                ':nom' => $usuario
            ]);

            $usuarioBD = $stmt -> fetch();

            if($usuarioBD && password_verify($pass, $usuarioBD['Clave'])){
                $_SESSION['nom_usuario'] = $usuarioBD['Nombre'];
                $_SESSION['rol'] = $usuarioBD['Rol'];
                header("Location: config.php");
                exit();
            }else{
                header("Location: index.php?error=1");
                exit();
            }
        }catch(PDOException $e){
            echo "Error en QUERY: " . $e -> getMessage();
            echo "No se pudieron obtener los datos.";
        }finally{
            require_once 'cierre.php';
        }
    }

    function existeUsuario($usuario){
        require_once 'conexion.php';
        try{
            $sql = "SELECT COUNT(*) FROM usuarios WHERE Nombre = :nom";
            $stmt = $pdo -> prepare($sql);

            $stmt -> execute([
                ':nom' => $usuario
            ]);

            return $stmt->fetchColumn() > 0;

        }catch(PDOException $e){
            echo "Error en QUERY de comprobación: " . $e -> getMessage();
            echo "No se pudieron obtener los datos.";
        }finally{
            require_once 'cierre.php';
        }
    }

    function insertarUsuario($usuario, $pass){
    require 'conexion.php';

    try{
        $passHash = password_hash($pass, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (Nombre, Clave, Rol) VALUES (:nom, :clave, 0)";
        $stmt = $pdo->prepare($sql);
    
        $stmt->execute([
            ':nom' => $usuario,
            ':clave' => $passHash
        ]);

        return true; 

    }catch(PDOException $e){
        echo "<h3>ERROR DE MYSQL AL INSERTAR:</h3>";
        echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
        exit();
    }finally{
        require_once 'cierre.php';
    }
}
?>