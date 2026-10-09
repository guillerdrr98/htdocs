<?php
    // Nombres de colores disponibles
    $colores_disponibles = [
        "azul", "rojo", "verde", "amarillo", 
        "naranja", "rosa", "morado", "gris"
    ];

    $colores_hex = [
        "#0095FF", "#FF0000", "#09FF00", "#FFFB00",
        "#FF8800", "#FF00E1", "#7700ff", "#858585"
    ];

    function pintar_circulos(array $colores) {
        $total = count($colores);

        $radio = 30;
        $espaciado = 80;
        $cy = 50;
        $ancho_svg = $total * $espaciado;
        $alto_svg = 100;

        $svg = "<svg width='{$ancho_svg}' height='{$alto_svg}' xmlns='http://www.w3.org/2000/svg'>\n";

        $i = 0;
        foreach ($colores as $hex) {
            // Usamos la clave $i para calcular la posición X de cada círculo
            $cx = ($i * $espaciado) + ($espaciado / 2);
            $svg .= "  <circle cx='{$cx}' cy='{$cy}' r='{$radio}' fill='{$hex}' stroke='#333' stroke-width='2' />\n";
            $i++;
        }

        $svg .= "</svg>";

        return $svg;
    }

    function pintar_circulos_negro($num_circulos) {

        $radio = 30;
        $espaciado = 80;
        $cy = 50;
        $ancho_svg = $num_circulos * $espaciado;
        $alto_svg = 100;

        $svg = "<svg width='{$ancho_svg}' height='{$alto_svg}' xmlns='http://www.w3.org/2000/svg'>\n";

        for ($i = 0; $i < $num_circulos; $i++) {
            // Usamos la clave $i para calcular la posición X de cada círculo
            $cx = ($i * $espaciado) + ($espaciado / 2);
            $svg .= "  <circle cx='{$cx}' cy='{$cy}' r='{$radio}' fill='#000000' stroke='#333' stroke-width='2' />\n";
        };

        $svg .= "</svg>";

        return $svg;
    }


    // PROCESAMIENTO DE DATOS DEL FORMULARIO
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $num_circulos = isset($_POST['num_circulos']) ? (int)$_POST['num_circulos'] : 0;
    $num_colores = isset($_POST['num_colores']) ? (int)$_POST['num_colores'] : 0;

    // Extraer los N primeros colores de la lista
    $paleta_seleccionada = array_slice($colores_hex, 0, $num_colores);
    $paleta_texto = array_slice($colores_disponibles, 0, $num_colores);

    // Generar la lista de círculos asignando aleatoriamente colores PERO solo de los N primeros seleccionados
    $lista_colores = [];
    for ($i = 0; $i < $num_circulos; $i++) {
        // Seleccionamos un color al azar dentro de la paleta restringida ($paleta_seleccionada)
        $color_azar = $paleta_seleccionada[rand(0, count($paleta_seleccionada)-1)];
        array_push($lista_colores, $color_azar);
    }

    // Generar el SVG
    $svg_resultado = pintar_circulos($lista_colores);

    $svg_res_negro = pintar_circulos_negro($num_circulos);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Círculos Dibujados</title>
</head>
<body>
    <h2>Resultado</h2>

    <p><strong>Nombres de los colores generados aleatoriamente:</strong> 
        <?= implode(", ", $paleta_texto) ?>
    </p>

    <h3>Círculos:</h3>
    <div>
        <?= $svg_resultado ?><br>
        <?= $svg_res_negro ?>
    </div>

    <br>
    <a href="index.html">Volver al formulario</a>
</body>
</html>