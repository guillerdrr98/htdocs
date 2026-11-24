<?php
    /**
     * Devuelve un array con los nombres de archivo emoji1.png ... emojiN.png.
     *
     * @param int $n Número de emojis (esperado entre 4 y 10).
     * @return array<int, string> Lista de nombres de imagen.
     */
    function obtenerEmojis(int $n): array
    {
        if ($n < 4) {
            $n = 4;
        } elseif ($n > 10) {
            $n = 10;
        }

        $emojis = [];
        for ($i = 1; $i <= $n; $i++) {
            $emojis[] = "emoji" . $i . ".png";
        }

        return $emojis;
    }

    /**
     * Genera el HTML con el emoji asignado a un contacto según su posición en el lote.
     *
     * @param array<int, string> $emojis Lista de nombres de archivo (ej. emoji1.png).
     * @param int $indiceContacto Índice del contacto dentro del lote (0, 1, 2...).
     * @return string Fragmento HTML con la imagen del emoji asignado.
     */
    function pintarEmojis(array $emojis, int $indiceContacto): string
    {
        if (empty($emojis)) {
            return "";
        }

        $archivo = $emojis[$indiceContacto % count($emojis)];
        $archivoSeguro = htmlspecialchars($archivo, ENT_QUOTES, 'UTF-8');
        $nombreEmoji = htmlspecialchars(pathinfo($archivo, PATHINFO_FILENAME), ENT_QUOTES, 'UTF-8');

        return "<img src='../imagenes/$archivoSeguro' alt='$nombreEmoji' width='28' height='28'>";
    }
?>