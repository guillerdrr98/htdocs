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
     * Genera el HTML con los emojis disponibles para seleccionar en un contacto.
     *
     * @param array<int, string> $emojis Lista de nombres de archivo (ej. emoji1.png).
     * @param int $indiceContacto Índice del contacto dentro del lote (0, 1, 2...).
     * @return string Fragmento HTML con las imágenes y radios.
     */
    function pintarEmojis(array $emojis, int $indiceContacto): string
    {
        $html = "";
        foreach ($emojis as $i => $archivo) {
            $archivoSeguro = htmlspecialchars($archivo, ENT_QUOTES, 'UTF-8');
            $valorEmoji = htmlspecialchars(pathinfo($archivo, PATHINFO_FILENAME), ENT_QUOTES, 'UTF-8');
            $checked = ($i === 0) ? " checked" : "";

            $html .= "<label style='margin-right: 10px; display: inline-flex; align-items: center; gap: 4px;'>";
            $html .= "<input type='radio' name='contactos[$indiceContacto][emoji]' value='$valorEmoji'$checked required>";
            $html .= "<img src='../imagenes/$archivoSeguro' alt='$valorEmoji' width='28' height='28'>";
            $html .= "</label>";
        }

        return $html;
    }
?>