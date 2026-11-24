<?php
    /**
     * Verifica las credenciales de un usuario e inicia su sesión si son válidas.
     *
     * @param string $usuario Nombre de usuario introducido.
     * @param string $pass Contraseña en texto plano introducida.
     * @return string Mensaje de error si falla la autenticación, o vacío si redirige.
     */
    function verificarUsuPass(string $usuario, string $pass): string
    {
        require '../ConexionBD/conexion.php';

        try {
            $sql = "SELECT codigo, nombre, clave, rol FROM usuarios WHERE nombre = :nom";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nom' => $usuario]);
            $usuarioBD = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuarioBD && password_verify($pass, $usuarioBD['clave'])) {
                session_regenerate_id(true);
                $_SESSION['cod_usuario'] = (int) $usuarioBD['codigo'];
                $_SESSION['nom_usuario'] = $usuarioBD['nombre'];
                $_SESSION['rol'] = (int) $usuarioBD['rol'];

                if ($_SESSION['rol'] === 1) {
                    header("Location: admin.php");
                } else {
                    header("Location: inicio.php");
                }
                exit();
            }

            return "Usuario y/o contraseña incorrectos.";
        } catch (PDOException $e) {
            error_log("Error en SELECT usuario: " . $e->getMessage());
            return "No se pudo verificar el usuario debido a un error de conexión.";
        } finally {
            require '../ConexionBD/cierre.php';
        }
    }

    /**
     * Comprueba si ya existe un usuario con el nombre indicado.
     *
     * @param string $usuario Nombre de usuario.
     * @return bool True si existe, false en caso contrario.
     */
    function existeUsuario(string $usuario): bool
    {
        require '../ConexionBD/conexion.php';

        try {
            $sql = "SELECT COUNT(*) FROM usuarios WHERE nombre = :nom";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':nom' => $usuario]);

            return (int) $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Error en SELECT existeUsuario: " . $e->getMessage());
            return false;
        } finally {
            require '../ConexionBD/cierre.php';
        }
    }

    /**
     * Inserta un usuario nuevo con rol 0 y contraseña cifrada con ARGON2ID.
     *
     * @param string $usuario Nombre de usuario.
     * @param string $pass Contraseña en texto plano.
     * @return int|false ID del usuario insertado o false si falla.
     */
    function insertarUsuario(string $usuario, string $pass): int|false
    {
        require '../ConexionBD/conexion.php';

        try {
            $passHash = password_hash($pass, PASSWORD_ARGON2ID);
            if ($passHash === false) {
                return false;
            }

            $sql = "INSERT INTO usuarios (nombre, clave, rol) VALUES (:nom, :clave, 0)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nom' => $usuario,
                ':clave' => $passHash
            ]);

            return (int) $pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error en INSERT usuario: " . $e->getMessage());
            return false;
        } finally {
            require '../ConexionBD/cierre.php';
        }
    }

    /**
     * Obtiene la configuración actual de la agenda (fila id = 1).
     *
     * @return array<string, int> Valores de max_lote, num_emojis y max_contactos.
     */
    function obtenerConfiguracion(): array
    {
        require '../ConexionBD/conexion.php';

        try {
            $sql = "SELECT max_lote, num_emojis, max_contactos FROM configuracion WHERE id = 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($fila) {
                return [
                    'max_lote' => (int) $fila['max_lote'],
                    'num_emojis' => (int) $fila['num_emojis'],
                    'max_contactos' => (int) $fila['max_contactos'],
                ];
            }

            return [
                'max_lote' => 5,
                'num_emojis' => 6,
                'max_contactos' => 50,
            ];
        } catch (PDOException $e) {
            error_log("Error en SELECT configuracion: " . $e->getMessage());
            return [
                'max_lote' => 5,
                'num_emojis' => 6,
                'max_contactos' => 50,
            ];
        } finally {
            require '../ConexionBD/cierre.php';
        }
    }

    /**
     * Actualiza los parámetros de configuración de la agenda en la base de datos.
     *
     * @param int $maxLote Máximo de contactos por lote (3-8).
     * @param int $numEmojis Número de emojis disponibles (4-10).
     * @param int $maxContactos Máximo de contactos por usuario (10-100).
     * @return bool True si se actualizó correctamente, false en caso contrario.
     */
    function actualizarConfiguracion(int $maxLote, int $numEmojis, int $maxContactos): bool
    {
        require '../ConexionBD/conexion.php';

        try {
            $sql = "UPDATE configuracion
                    SET max_lote = :max_lote,
                        num_emojis = :num_emojis,
                        max_contactos = :max_contactos
                    WHERE id = 1";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':max_lote' => $maxLote,
                ':num_emojis' => $numEmojis,
                ':max_contactos' => $maxContactos,
            ]);
        } catch (PDOException $e) {
            error_log("Error en UPDATE configuracion: " . $e->getMessage());
            return false;
        } finally {
            require '../ConexionBD/cierre.php';
        }
    }

    /**
     * Obtiene todos los usuarios registrados junto con el total de contactos guardados.
     *
     * @return array<int, array<string, mixed>> Lista de usuarios con su conteo de contactos.
     */
    function listarUsuariosConContactos(): array
    {
        require '../ConexionBD/conexion.php';

        try {
            $sql = "SELECT u.codigo, u.nombre, u.rol, COUNT(c.id) AS total_contactos
                    FROM usuarios u
                    LEFT JOIN contactos c ON u.codigo = c.codigousu
                    GROUP BY u.codigo, u.nombre, u.rol
                    ORDER BY u.codigo ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en SELECT usuarios con contactos: " . $e->getMessage());
            return [];
        } finally {
            require '../ConexionBD/cierre.php';
        }
    }

    /**
     * Cuenta cuántos contactos tiene guardados un usuario concreto.
     *
     * @param int $codUsuario Código del usuario en la tabla usuarios.
     * @return int Número de contactos registrados.
     */
    function contarContactosUsuario(int $codUsuario): int
    {
        require '../ConexionBD/conexion.php';

        try {
            $sql = "SELECT COUNT(*) FROM contactos WHERE codigousu = :cod";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':cod' => $codUsuario]);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error en SELECT contarContactosUsuario: " . $e->getMessage());
            return 0;
        } finally {
            require '../ConexionBD/cierre.php';
        }
    }

    /**
     * Inserta un contacto asociado a un usuario en la tabla contactos.
     *
     * @param int $codUsuario Código del usuario propietario.
     * @param array<string, string> $contacto Datos del contacto (nombre, apellidos, telefono, email, emoji).
     * @return bool True si se insertó correctamente, false en caso contrario.
     */
    function insertarContacto(int $codUsuario, array $contacto): bool
    {
        require '../ConexionBD/conexion.php';

        try {
            $sql = "INSERT INTO contactos (codigousu, nombre, apellidos, telefono, email, emoji)
                    VALUES (:codigousu, :nombre, :apellidos, :telefono, :email, :emoji)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([
                ':codigousu' => $codUsuario,
                ':nombre' => $contacto['nombre'],
                ':apellidos' => $contacto['apellidos'],
                ':telefono' => $contacto['telefono'],
                ':email' => $contacto['email'],
                ':emoji' => $contacto['emoji'],
            ]);
        } catch (PDOException $e) {
            error_log("Error en INSERT contacto: " . $e->getMessage());
            return false;
        } finally {
            require '../ConexionBD/cierre.php';
        }
    }

    /**
     * Obtiene el total de contactos, porcentaje sobre max_contactos, último alta y gráfica por usuario.
     *
     * @return array<int, array<string, mixed>> Lista de usuarios ordenada por total de contactos.
     */
    function obtenerEstadisticasUsuarios(): array
    {
        require '../ConexionBD/conexion.php';

        try {
            $stmtConfig = $pdo->prepare("SELECT max_contactos FROM configuracion WHERE id = 1");
            $stmtConfig->execute();
            $maxContactos = (int) ($stmtConfig->fetchColumn() ?: 50);

            $sql = "SELECT u.codigo,
                           u.nombre,
                           COUNT(c.id) AS total_contactos,
                           MAX(c.fecha_alta) AS ultimo_alta
                    FROM usuarios u
                    LEFT JOIN contactos c ON u.codigo = c.codigousu
                    GROUP BY u.codigo, u.nombre
                    ORDER BY total_contactos DESC, u.codigo ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($filas as &$fila) {
                $cont = (int) $fila['total_contactos'];
                $porcentaje = ($maxContactos > 0) ? ($cont * 100.0) / $maxContactos : 0.0;
                $fila['porcentaje'] = min(100.0, $porcentaje);
            }
            unset($fila);

            return $filas;
        } catch (PDOException $e) {
            error_log("Error en SELECT estadisticas usuarios: " . $e->getMessage());
            return [];
        } finally {
            require '../ConexionBD/cierre.php';
        }
    }
?>