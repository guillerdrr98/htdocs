<?php
    function verificarUsuPass($usuario, $pass){
        require_once 'conexion.php';
        try{
            $sql = "SELECT * FROM usuarios WHERE BINARY Nombre = :nom"; // Descomentar BINARY si se desea que se distinga entre mayus y minus a la hora de comprobar
            $stmt = $pdo -> prepare($sql);

            $stmt -> execute([
                ':nom' => $usuario
            ]);

            $usuarioBD = $stmt -> fetch();

            if($usuarioBD && password_verify($pass, $usuarioBD['Clave'])){
                $_SESSION['nom_usuario'] = $usuarioBD['Nombre'];
                $_SESSION['rol'] = $usuarioBD['Rol'];

                if ($_SESSION['rol'] == 1) {
                    header("Location: config.php"); // Si es admin (tipo 1), va a la configuración
                } else {
                    header("Location: solucion.php"); // Si es usuario normal, va directo al juego
                }
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

    function registrarJugada($nombreUsuario, $acierto) {
        $codigousu = obtenerIdUsuario($nombreUsuario);
        
        if (!$codigousu) {
            return false; // Si no encuentra al usuario, no registra nada
        }

        require 'conexion.php';
        try {
            $sql = "INSERT INTO jugadas (codigousu, acierto) VALUES (:usu, :aci)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':usu' => $codigousu,
                ':aci' => $acierto
            ]);
            return true;
        } catch(PDOException $e) {
            error_log("Error en INSERT jugada: " . $e->getMessage());
            return false;
        } finally {
            require_once 'cierre.php';
        }
    }

    function obtenerRanking() {
        require_once 'conexion.php';
        try {
            $sql = "SELECT u.Codigo AS codigousu, u.Nombre AS nombre_usuario, SUM(j.acierto) AS aciertos
                    FROM usuarios u
                    INNER JOIN jugadas j ON u.Codigo = j.codigousu
                    GROUP BY u.Codigo, u.Nombre
                    ORDER BY aciertos DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Error en RANKING: " . $e->getMessage());
            echo "No se pudo obtener el ranking.";
            return [];
        } finally {
            require_once 'cierre.php';
        }
    }

    function obtenerIdUsuario($nombreUsuario) {
        require_once 'conexion.php';
        try {
            $sql = "SELECT Codigo FROM usuarios WHERE Nombre = :nombre";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nombre' => $nombreUsuario]);
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['Codigo'] : null;
        } catch(PDOException $e) {
            error_log("Error al obtener ID de usuario: " . $e->getMessage());
            return null;
        } finally {
            require_once 'cierre.php';
        }
    }
?>