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

    // Función para generar el SVG de las jugadas del Simón
    function actualizar_juego(array $jugada, int $total_circulos, array $paleta_texto, array $paleta_hex): string {
        $colores_a_pintar = [];

        for ($i = 0; $i < $total_circulos; $i++) {
            // Si la posición $i ya fue jugada, traducimos el nombre de color a su Hex
            if (isset($jugada[$i])) {
                $nombre_color = $jugada[$i];
                $posicion = array_search($nombre_color, $paleta_texto); //array_search() devuelve el índice del elemento en caso de que exista, false en caso contrario
                $colores_a_pintar[] = $paleta_hex[$posicion];
            } else {
                // Si aún no se ha pulsado, colocamos el círculo en negro
                $colores_a_pintar[] = "#000000";
            }
        }

        // Delegamos la generación del SVG a pintar_circulos()
        return pintar_circulos($colores_a_pintar);
    }
?>