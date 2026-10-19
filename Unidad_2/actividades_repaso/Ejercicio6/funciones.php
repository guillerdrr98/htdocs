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

    // Prepara el array de colores según el avance y delega el dibujo
    function actualizar_juego(array $jugada, int $total_circulos, array $paleta): string {
        $colores_a_pintar = [];

        for ($i = 0; $i < $total_circulos; $i++) {

            $colores_a_pintar[] = (isset($jugada[$i]) && isset($paleta[$jugada[$i]])) ? $paleta[$jugada[$i]] : "#000000";
        }

        return pintar_circulos($colores_a_pintar);
    }
?>