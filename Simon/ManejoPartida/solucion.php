<?php
    session_start();
    require 'funciones.php';

    // 1. Lista completa de colores disponibles
    $colores = [
        "azul" => "#0095FF", "rojo" => "#FF0000", 
        "verde" => "#09FF00", "amarillo" => "#FFFB00", 
        "naranja" => "#FF8800", "rosa" => "#FF00E1", 
        "morado" => "#7700ff", "gris" => "#858585"
    ];

    // 2. Si viene por POST desde config.php, actualizamos las cookies globalmente ('path' => '/')
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['color_fondo'])) {
            setcookie('cookie_fondo', $_POST['color_fondo'], ['expires' => time() + (86400 * 30), 'path' => '/']);
            $_COOKIE['cookie_fondo'] = $_POST['color_fondo']; 
        }

        if (isset($_POST['num_circulos'])) {
            setcookie('cookie_circulos', $_POST['num_circulos'], ['expires' => time() + (86400 * 30), 'path' => '/']);
            $_COOKIE['cookie_circulos'] = $_POST['num_circulos'];
        }

        if (isset($_POST['num_colores'])) {
            setcookie('cookie_colores', $_POST['num_colores'], ['expires' => time() + (86400 * 30), 'path' => '/']);
            $_COOKIE['cookie_colores'] = $_POST['num_colores'];
        }
    }

    // 3. Recogemos los valores actuales (vengan de cookies o recién guardados por POST)
    $color_form = isset($_COOKIE['cookie_fondo']) ? $_COOKIE['cookie_fondo'] : 'grey';
    $num_circulos = isset($_COOKIE['cookie_circulos']) ? (int)$_COOKIE['cookie_circulos'] : 7;
    $num_colores = isset($_COOKIE['cookie_colores']) ? (int)$_COOKIE['cookie_colores'] : 4;

    // 4. GENERAR LA COMBINACIÓN SIEMPRE (tanto para admin como para usuarios tipo 0)
    $paleta = array_slice($colores, 0, $num_colores, true);
    $claves_paleta = array_keys($paleta);

    $lista_solucion = [];
    $lista_nombres_solucion = [];

    for ($i = 0; $i < $num_circulos; $i++) {
        $valor_azar = $claves_paleta[rand(0, count($claves_paleta) - 1)];
        $lista_nombres_solucion[] = $valor_azar;
        $lista_solucion[] = $paleta[$valor_azar];
    }

    // Guardar en sesión para que la partida pueda leerlo
    $_SESSION['num_colores'] = $num_colores;
    $_SESSION['num_circulos'] = $num_circulos;
    $_SESSION['paleta'] = $paleta;
    $_SESSION['combinacion_colores_texto'] = $lista_nombres_solucion;
    $_SESSION['solucion'] = pintar_circulos($lista_solucion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simón dice... - Solución</title>
</head>
<body style="background-color: <?= $color_form ?>">
    <h2>¡Hola, <?= $_SESSION['nom_usuario'] ?>! Simón dice...:</h2>

    <p><strong>Paleta de colores disponible:</strong> <?= implode(", ", array_keys($_SESSION['paleta'])) ?></p>

    <h3>Combinación generada:</h3>
    <div><?= $_SESSION['solucion'] ?></div>

    <h3>En texto plano:</h3>
    <p><?= implode(" - ", $_SESSION['combinacion_colores_texto']) ?></p>

    <br>
    
    <!-- El botón de volver a configuración solo lo ve el administrador (rol === 1) -->
    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 1): ?>
        <a href="config.php"><button>Volver a configuración</button></a>
    <?php endif; ?>

    <!-- El botón de volver a configuración solo lo ve el administrador (rol === 0) -->
    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 0): ?>
        <a href="index.php"><button>Volver</button></a>
    <?php endif; ?>
    
    <a href="partida.php"><button>Empezar Partida</button></a>
</body>
</html>