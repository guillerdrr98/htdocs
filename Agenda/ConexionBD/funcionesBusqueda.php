<?php
    function verificarUsuPass($usuario, $pass){
        require_once 'conexion.php';
        try{
            $sql = "SELECT * FROM usuarios WHERE nombre = :nom";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nom' => $usuario]);
            $usuarioBD = $stmt->fetch();

            if($usuarioBD && password_verify($pass, $usuarioBD['clave'])){
                // Requisito: Regenerar ID de sesión por seguridad
                session_regenerate_id(true);

                $_SESSION['nom_usuario'] = $usuarioBD['nombre'];
                $_SESSION['rol'] = $usuarioBD['rol'];
                $_SESSION['codigo'] = $usuarioBD['codigo'];

                if ($_SESSION['rol'] == 1) {
                    header("Location: admin.php"); // Panel de administración
                } else {
                    header("Location: inicio.php"); // Panel de usuario normal
                }
                exit();
            } else {
                return "Usuario y/o contraseña incorrectos.";
            }
        }catch(PDOException $e){
            error_log("Error en SELECT: " . $e->getMessage());
            return "No se pudo verificar el usuario debido a un error de conexión.";
        }
    }

    function existeUsuario($usuario){
        require_once 'conexion.php';
        try{
            $sql = "SELECT COUNT(*) FROM usuarios WHERE nombre = :nom";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nom' => $usuario]);
            return $stmt->fetchColumn() > 0;
        }catch(PDOException $e){
            error_log("Error en SELECT: " . $e->getMessage());
            return false;
        }
    }

    function insertarUsuario($usuario, $pass){
        require 'conexion.php';
        try{
            // Requisito: Cifrado obligatorio con PASSWORD_ARGON2ID
            $passHash = password_hash($pass, PASSWORD_ARGON2ID);

            $sql = "INSERT INTO usuarios (nombre, clave, rol) VALUES (:nom, :clave, 0)";
            $stmt = $pdo->prepare($sql);
    
            $stmt->execute([
                ':nom' => $usuario,
                ':clave' => $passHash
            ]);

            $codigo = $pdo->lastInsertId();

            // Requisito: Iniciar sesión automáticamente tras el registro
            session_regenerate_id(true);
            $_SESSION['nom_usuario'] = $usuario;
            $_SESSION['rol'] = 0; // Rol 0 por defecto
            $_SESSION['codigo'] = $codigo;

            return true; 
        }catch(PDOException $e){
            error_log("Error en INSERT: " . $e->getMessage());
            die("Error SQL real: " . $e->getMessage());
            return false;
        }
    }

    function actualizarConfiguracion($max_lote, $num_emojis, $max_contactos) {
        require 'conexion.php';
        try {
            $sql = "UPDATE configuracion SET max_lote = :lote, num_emojis = :emojis, max_contactos = :max_cont WHERE id = 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':lote' => $max_lote,
                ':emojis' => $num_emojis,
                ':max_cont' => $max_contactos
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al actualizar configuración: " . $e->getMessage());
            return false;
        }
    }

    function obtenerConfiguracion() {
        require 'conexion.php';
        try {
            $stmt = $pdo->query("SELECT * FROM configuracion WHERE id = 1");
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error al leer configuración: " . $e->getMessage());
            return false;
        }
    }

    function obtenerUsuariosConContactos() {
        require 'conexion.php';
        try {
            $sql = "SELECT u.codigo, u.nombre, u.rol, COUNT(c.id) as total_contactos 
                    FROM usuarios u 
                    LEFT JOIN contactos c ON u.codigo = c.codigousu 
                    GROUP BY u.codigo, u.nombre, u.rol";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error al listar usuarios: " . $e->getMessage());
            return [];
        }
    }

    function contarContactosUsuario(int $codigoUsu): int {
        require 'conexion.php';
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM contactos WHERE codigousu = :cod");
            $stmt->execute([':cod' => $codigoUsu]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error al contar contactos del usuario: " . $e->getMessage());
            return 0;
        }
    }

    function insertarLoteContactos(int $codigoUsu, array $emojis, array $datosFormulario): bool {
        require 'conexion.php';
        try {
            // Iniciamos la transacción
            $pdo->beginTransaction();

            $sql = "INSERT INTO contactos (codigousu, nombre, apellidos, telefono, email, emoji, fecha) 
                    VALUES (:cod, :nombre, :apellidos, :telefono, :email, :emoji, NOW())";
            $stmt = $pdo->prepare($sql);

            foreach ($emojis as $i => $emoji) {
                $c = $datosFormulario[$i];
                $stmt->execute([
                    ':cod' => $codigoUsu,
                    ':nombre' => trim($c['nombre']),
                    ':apellidos' => trim($c['apellidos']),
                    ':telefono' => trim($c['telefono']),
                    ':email' => trim($c['email']),
                    ':emoji' => $emoji
                ]);
            }

            // Si todo va bien, confirmamos los cambios
            $pdo->commit();
            return true;
        } catch (Exception $e) {
            // Si algo falla, revertimos toda la operación
            $pdo->rollBack();
            error_log("Error en transacción de lote: " . $e->getMessage());
            return false;
        }
    }

    function obtenerTotalesUsuarios() {
        require 'conexion.php';
        try {
            $sql = "SELECT u.codigo, u.nombre, u.rol, COUNT(c.id) as total_contactos, MAX(c.fecha) as ultimo_contacto 
                    FROM usuarios u 
                    LEFT JOIN contactos c ON u.codigo = c.codigousu 
                    GROUP BY u.codigo, u.nombre, u.rol 
                    ORDER BY total_contactos DESC";
            $stmt = $pdo->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error al obtener totales de usuarios: " . $e->getMessage());
            return [];
        }
    }
?>