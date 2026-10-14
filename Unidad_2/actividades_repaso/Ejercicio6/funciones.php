<?php
    // Función que pinta la solución del juego de Simón en pantalla
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

    // Función que genera los círculos negros para jugar al Simón
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

    // 5. Función para generar el SVG del avance actual sin usar array_combine
    function generar_svg_juego(array $jugada, int $total_circulos, array $paleta_texto, array $paleta_hex): string {
        $radio = 30;
        $espaciado = 80;
        $cy = 50;
        $ancho_svg = $total_circulos * $espaciado;
        $alto_svg = 100;

        $svg = "<svg width='{$ancho_svg}' height='{$alto_svg}' xmlns='http://www.w3.org/2000/svg'>\n";

        for ($i = 0; $i < $total_circulos; $i++) {
            $cx = ($i * $espaciado) + ($espaciado / 2);
        
            if (isset($jugada[$i])) {
                $nombre_color = $jugada[$i];
                $posicion = array_search($nombre_color, $paleta_texto);
            
                if ($posicion !== false) {
                    $fill = $paleta_hex[$posicion];
                } else {
                    $fill = "#000000";
                }
            } else {
                $fill = "#000000"; // Negro si no se ha jugado aún
            }

            $svg .= "  <circle cx='{$cx}' cy='{$cy}' r='{$radio}' fill='{$fill}' stroke='#333' stroke-width='2' />\n";
        }

        $svg .= "</svg>";
        return $svg;
    }
?>