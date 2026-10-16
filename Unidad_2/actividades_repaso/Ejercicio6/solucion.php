<?php
    session_start();
    require 'funciones.php';

    // Nombres de colores disponibles
    $colores_disponibles = [
        "azul", "rojo", "verde", "amarillo", 
        "naranja", "rosa", "morado", "gris"
    ];
    // Colores en hexadecimal
    $colores_hex = [
        "#0095FF", "#FF0000", "#09FF00", "#FFFB00",
        "#FF8800", "#FF00E1", "#7700ff", "#858585"
    ];

    // PROCESAMIENTO DE DATOS DEL FORMULARIO
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $num_circulos = isset($_POST['num_circulos']) ? (int)$_POST['num_circulos'] : 0;
        $num_colores = isset($_POST['num_colores']) ? (int)$_POST['num_colores'] : 0;

        // Extraer los N primeros colores de la lista
        $nombre_usuario = isset($_POST['nom_usuario']) ? $_POST['nom_usuario'] : "";
        $paleta_seleccionada = array_slice($colores_hex, 0, $num_colores);
        $paleta_texto = array_slice($colores_disponibles, 0, $num_colores);

        // Generar la lista de círculos asignando aleatoriamente colores (solo de los N primeros seleccionados)
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

        // Generar el SVG
        $comb_solucion = pintar_circulos($lista_colores);

        // Guardamos los datos que consideremos necesarios en variables de sesión
        $_SESSION['combinacion_colores_texto'] = $lista_nombres_colores;
        $_SESSION['solucion'] = $comb_solucion;
        $_SESSION['paleta_texto'] = $paleta_texto;
        $_SESSION['num_circulos'] = $num_circulos;
        $_SESSION['nom_usuario'] = $nombre_usuario;
        $_SESSION['colores_hex'] = $paleta_seleccionada;

        // Inicializamos las variables de sesión "jugada" y "pulsaciones" aquí 
        // para que el reset de cada partida sea efectivo y no genere problemas con la partida
        $_SESSION['jugada'] = array();
        $_SESSION['pulsaciones'] = 0;
    }

    // Accedemos a los valores de las variables de sesión para su posterior uso
    $combinacion_sesion = $_SESSION['combinacion_colores_texto'];
    $solucion_final = $_SESSION['solucion'];
    $colores_dispo_texto = $_SESSION['paleta_texto'];
    $nombre = $_SESSION['nom_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Simón dice... - Solución</title>
</head>
<body>
    <h2>¡Hola, <?= $nombre ?>! Simón dice...:</h2>

    <p><strong>Paleta de colores disponible:</strong> 
        <?= implode(", ", $colores_dispo_texto) ?>
    </p>

    <h3>Combinación de colores generada:</h3>
    <div>
        <?= $solucion_final ?>
    </div>

    <h3>Combinación de colores generada en texto plano:</h3>
    <div>
        <p><?= implode(" - ", $combinacion_sesion) ?></p>
    </div>

    <br>
    <a href="index.php">
        <button>Volver al formulario</button>
    </a>
    <a href="partida.php">
        <button>Empezar Partida</button>
    </a>
</body>
</html>