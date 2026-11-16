<?php
    function generarMazo($cartasBase){
        $cartas= [
            $cartasBase[0], $cartasBase[1], $cartasBase[2],
            $cartasBase[0], $cartasBase[1], $cartasBase[2]
        ];

        $mazo = ['','','','','',''];

        for ($i = 0; $i < 6; $i++) {
            do {
                $pos = rand(0, 5);
            } while ($mazo[$pos] !== '');

            $mazo[$pos] = $cartas[$i];
        }

        return $mazo;
    }

    function pintarCartas($mazo, $cartaLevantada = -1) {

        $rutaImg = '../Imagenes/'; 
        $cartaNegra = 'boca_abajo.jpg';

        for ($i = 0; $i < 6; $i++) {
            if ($i === $cartaLevantada) {
                $archivo = $mazo[$i];
            } else {
                $archivo = $cartaNegra;
            }

            echo '<img src="' . $rutaImg . $archivo . '" alt="Carta ' . ($i + 1) . '" width="120" height="180"> ';
        }
    }
?>