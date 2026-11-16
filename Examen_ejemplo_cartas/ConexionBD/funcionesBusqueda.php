<?php
    function verificarUsuPass($login, $pass){
        require 'conexion.php';
        try{
            $sql = "SELECT * FROM jugador WHERE BINARY login = :login";
            $stmt = $pdo -> prepare($sql);

            $stmt -> execute([
                ':login' => $login
            ]);

            $usuarioBD = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($usuarioBD && $pass === $usuarioBD['clave']){
                $_SESSION['nom_usuario'] = $usuarioBD['nombre'];
                $_SESSION['login'] = $usuarioBD['login'];
                header("Location: ../Aplicacion/mostrarcartas.php");
                exit();
            } else {
                return "Usuario y/o contraseña incorrectos.";
            }
        }catch(PDOException $e){
            error_log("Error en SELECT: " . $e -> getMessage());
            return "No se pudo verificar el usuario debido a un error de conexión.";
        }finally{
            require 'cierre.php';
        }
    }

    function actualizarPuntuacion($login, $deltaPuntos, $intentos) {
        require 'conexion.php';
        try {
            $sql = "UPDATE jugador 
                    SET puntos = puntos + :puntos, 
                        extra = extra + :intentos 
                    WHERE BINARY login = :login";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':puntos'   => $deltaPuntos,
                ':intentos' => $intentos,
                ':login'    => $login
            ]);
        } catch (PDOException $e) {
            error_log("Error en UPDATE: " . $e->getMessage());
        } finally {
            require 'cierre.php';
        }
    }

    function obtenerJugadores() {
        require 'conexion.php';
        try {
            $sql = "SELECT nombre, puntos, extra FROM jugador";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en SELECT jugadores: " . $e->getMessage());
            return [];
        } finally {
            require 'cierre.php';
        }
    }
?>