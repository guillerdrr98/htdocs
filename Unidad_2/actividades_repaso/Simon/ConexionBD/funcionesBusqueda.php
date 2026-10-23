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

            if($usuarioBD && password_verify($usuarioBD['Clave'], $pass)){
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
        $sql = "INSERT INTO usuarios (Nombre, Clave, Rol) VALUES (:nom, :clave, 0)";
        $stmt = $pdo->prepare($sql);
    
        $stmt->execute([
            ':nom' => $usuario,
            ':clave' => $pass
        ]);

        return true; 

    }catch(PDOException $e){
        error_log("Error en QUERY inserción: " . $e->getMessage());
        echo "Fallo al insertar usuario en la BD";
    }finally{
        require_once 'cierre.php';
    }
}
?>