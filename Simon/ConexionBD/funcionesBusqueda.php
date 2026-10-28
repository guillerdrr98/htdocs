<?php
    function verificarUsuPass($usuario, $pass){
        require_once 'conexion.php';
        try{
            $sql = "SELECT * FROM usuarios WHERE BINARY Nombre = :nom";
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
            } else {
                return "Usuario y/o contraseña incorrectos.";
            }
        }catch(PDOException $e){
            error_log("Error en SELECT: " . $e -> getMessage());
            return "No se pudo verificar el usuario debido a un error de conexión.";
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
            error_log("Error en SELECT: " . $e -> getMessage());
            echo "No se pudo realizar la comprobación.";
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
        error_log("Error en INSERT: " . $e -> getMessage());
        echo "Error al insertar los datos.";
    }finally{
        require_once 'cierre.php';
    }
}
?>