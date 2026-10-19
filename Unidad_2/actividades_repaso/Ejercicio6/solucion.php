<?php
    session_start();
    require 'funciones.php';

    // Lista completa de colores disponibles
    $colores = [
        "azul" => "#0095FF", "rojo" => "#FF0000", 
        "verde" => "#09FF00", "amarillo" => "#FFFB00", 
        "naranja" => "#FF8800", "rosa" => "#FF00E1", 
        "morado" => "#7700ff", "gris" => "#858585"
    ];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['num_colores'])) {
        $nombre_usuario = $_POST['nom_usuario'];
        $num_circulos = (int)$_POST['num_circulos'];
        $num_colores = (int)$_POST['num_colores'];

        // Extraer los primeros N colores de la lista global usando array_slice
        $paleta = array_slice($colores, 0, $num_colores, true);
        $claves_paleta = array_keys($paleta);

        $lista_solucion = [];
        $lista_nombres_solucion = [];

        // Generar la combinación secreta aleatoria
        for ($i = 0; $i < $num_circulos; $i++) {
            $valor_azar = $claves_paleta[rand(0, count($claves_paleta) - 1)];
            $lista_nombres_solucion[] = $valor_azar;
            $lista_solucion[] = $paleta[$valor_azar];
        }

        // Guardar en sesión
        $_SESSION['nom_usuario'] = $nombre_usuario;
        $_SESSION['num_colores'] = $num_colores;
        $_SESSION['num_circulos'] = $num_circulos;
        $_SESSION['paleta'] = $paleta;
        $_SESSION['combinacion_colores_texto'] = $lista_nombres_solucion;
        $_SESSION['solucion'] = pintar_circulos($lista_solucion);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simón dice... - Solución</title>
</head>
<body>
    <h2>¡Hola, <?= $_SESSION['nom_usuario'] ?>! Simón dice...:</h2>

    <p><strong>Paleta de colores disponible:</strong> <?= implode(", ", array_keys($_SESSION['paleta'])) ?></p>

    <h3>Combinación generada:</h3>
    <div><?= $_SESSION['solucion'] ?></div>

    <h3>En texto plano:</h3>
    <p><?= implode(" - ", $_SESSION['combinacion_colores_texto']) ?></p>

    <br>
    <a href="index.php"><button>Volver al formulario</button></a>
    <a href="partida.php"><button>Empezar Partida</button></a>
</body>
</html>