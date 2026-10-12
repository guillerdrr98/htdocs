<?php
    session_start();
    require 'funciones.php';

    // Nombres de colores disponibles
    $colores_disponibles = [
        "azul", "rojo", "verde", "amarillo", 
        "naranja", "rosa", "morado", "gris"
    ];

    $colores_hex = [
        "#0095FF", "#FF0000", "#09FF00", "#FFFB00",
        "#FF8800", "#FF00E1", "#7700ff", "#858585"
    ];

    // PROCESAMIENTO DE DATOS DEL FORMULARIO
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $num_circulos = isset($_POST['num_circulos']) ? (int)$_POST['num_circulos'] : 0;
    $num_colores = isset($_POST['num_colores']) ? (int)$_POST['num_colores'] : 0;

    // Extraer los N primeros colores de la lista
    $paleta_seleccionada = array_slice($colores_hex, 0, $num_colores);
    $paleta_texto = array_slice($colores_disponibles, 0, $num_colores);

    // Generar la lista de círculos asignando aleatoriamente colores PERO solo de los N primeros seleccionados
    $lista_colores = [];
    $lista_nombres_colores = [];
    for ($i = 0; $i < $num_circulos; $i++) {
        if (!empty($paleta_seleccionada)) {
            $indice_azar = rand(0, count($paleta_seleccionada) - 1);
            $color_azar = $paleta_seleccionada[$indice_azar];
            
            // Guardamos el color en formato hexadecimal para el SVG
            array_push($lista_colores, $color_azar);
            // Guardamos también su nombre correspondiente en texto
            array_push($lista_nombres_colores, $paleta_texto[$indice_azar]);
        }
    }

    $_SESSION['combinacion_colores_texto'] = $lista_nombres_colores;

    // Generar el SVG
    $svg_resultado = pintar_circulos($lista_colores);
    $svg_negro = pintar_circulos_negro($num_circulos);

    $_SESSION['svg_resultado'] = $svg_resultado;
    $_SESSION['svg_negro'] = $svg_negro;
    $_SESSION['paleta_texto'] = $paleta_texto;
}

$combinacion_sesion = $_SESSION['combinacion_colores_texto'];
$svg_resultado = $_SESSION['svg_resultado'];
$svg_negro = $_SESSION['svg_negro'];
$paleta_texto = $_SESSION['paleta_texto'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Combinación de Colores Modular</title>
</head>
<body>
    <h2>Resultado del Servidor</h2>

    <p><strong>Paleta de colores disponible:</strong> 
        <?= implode(", ", $paleta_texto) ?>
    </p>

    <h3>Círculos Negros:</h3>
    <div>
        <?= $svg_negro ?>
    </div>

    <h3>Combinación de colores generada (en formato texto desde <code>\$_SESSION</code>):</h3>
    <div>
        <ul>
            <?php foreach ($combinacion_sesion as $color_nombre): ?>
                <li><?= $color_nombre?></li>
            <?php endforeach; ?>
        </ul>
        <p><strong>Texto plano:</strong> <?= implode(" - ", $combinacion_sesion) ?></p>
    </div>

    <br>
    <a href="index.php">Volver al formulario</a>
</body>
</html>