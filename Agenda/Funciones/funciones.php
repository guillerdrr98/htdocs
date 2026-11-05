<?php
// Constante con 10 emojis Unicode
define('EMOJIS', ['🐱', '🚀', '🍕', '⚽', '🎸', '📚', '💡', '🏆', '⭐', '💻']);

/**
 * Devuelve los $num primeros emojis de la constante según la configuración.
 */
function emojisDisponibles(int $num): array {
    return array_slice(EMOJIS, 0, $num);
}

/**
 * Devuelve un emoji aleatorio del array de emojis disponibles.
 */
function emojiAleatorio(array $emojis): string {
    return $emojis[array_rand($emojis)];
}

/**
 * Valida los campos de un contacto (nombre, apellidos, teléfono de 9 dígitos y email válido).
 * Devuelve un array asociativo con los errores detectados (vacío si es correcto).
 */
function validarContacto(array $c): array {
    $errores = [];

    if (empty(trim($c['nombre'] ?? ''))) {
        $errores['nombre'] = 'El nombre es obligatorio.';
    }
    if (empty(trim($c['apellidos'] ?? ''))) {
        $errores['apellidos'] = 'Los apellidos son obligatorios.';
    }

    $telefono = trim($c['telefono'] ?? '');
    if (!preg_match('/^\d{9}$/', $telefono)) {
        $errores['telefono'] = 'El teléfono debe tener exactamente 9 dígitos.';
    }

    $email = trim($c['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Email no válido';
    }

    return $errores;
}

/**
 * Devuelve el HTML del bloque del contacto $i, conservando valores y mostrando errores.
 */
function pintarFormularioContactos(int $i, string $emoji, array $valores, array $errores): string {
    $nombre = htmlspecialchars($valores['nombre'] ?? '');
    $apellidos = htmlspecialchars($valores['apellidos'] ?? '');
    $telefono = htmlspecialchars($valores['telefono'] ?? '');
    $email = htmlspecialchars($valores['email'] ?? '');

    $errNombre = isset($errores['nombre']) ? "<br><span style='color:red;'>{$errores['nombre']}</span>" : '';
    $errApellidos = isset($errores['apellidos']) ? "<br><span style='color:red;'>{$errores['apellidos']}</span>" : '';
    $errTelefono = isset($errores['telefono']) ? "<br><span style='color:red;'>{$errores['telefono']}</span>" : '';
    $errEmail = isset($errores['email']) ? "<br><span style='color:red;'>{$errores['email']}</span>" : '';

    return "
    <div style='border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;'>
        <span style='font-size: 24px; vertical-align: middle; margin-right: 15px;'>$emoji</span>
        <label>Nombre <input type='text' name='contacto[$i][nombre]' value='$nombre'></label> $errNombre
        <label>Apellidos <input type='text' name='contacto[$i][apellidos]' value='$apellidos'></label> $errApellidos
        <br><br>
        <label>Teléfono <input type='text' name='contacto[$i][telefono]' value='$telefono'></label> $errTelefono
        <label>Email <input type='text' name='contacto[$i][email]' value='$email'></label> $errEmail
    </div>";
}
?>