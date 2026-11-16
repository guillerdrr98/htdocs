<?php
    session_start();

    // Protección de acceso
    if (!isset($_SESSION['nom_usuario']) || !isset($_SESSION['login'])) {
        header("Location: index.php");
        exit();
    }

    require_once '../conexionBD/funcionesBusqueda.php';

    // Si entran directamente por URL sin haber enviado el formulario, volvemos al juego
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['pos1'], $_POST['pos2']) || !isset($_SESSION['mazo'])) {
        header("Location: mostrarcartas.php");
        exit();
    }

    $pos1 = (int)$_POST['pos1'];
    $pos2 = (int)$_POST['pos2'];
    $intentos = $_SESSION['intentos'] ?? 0;
    $mazo = $_SESSION['mazo'];

    // Convertimos posiciones 1..6 a índices 0..5
    $index1 = $pos1 - 1;
    $index2 = $pos2 - 1;

    // Comprobamos que las posiciones sean válidas, distintas entre sí y tengan la misma carta
    $acierto = false;
    if ($pos1 >= 1 && $pos1 <= 6 && $pos2 >= 1 && $pos2 <= 6 && $pos1 !== $pos2) {
        if ($mazo[$index1] === $mazo[$index2]) {
            $acierto = true;
        }
    }

    if ($acierto) {
        $mensajeResultado = "Acierto posiciones $pos1 y $pos2 después de $intentos intentos";
        $mensajeDetalle = "Se le sumará 1 punto, así como $intentos intentos";
            $deltaPuntos = 1;
    } else {
        $mensajeResultado = "Fallo posiciones $pos1 y $pos2 después de $intentos intentos";
        $mensajeDetalle = "Se le restará 1 punto, y se le sumarán $intentos intento/s";
        $deltaPuntos = -1;
    }

    // 1. Actualizamos la base de datos
    actualizarPuntuacion($_SESSION['login'], $deltaPuntos, $intentos);

    // 2. Limpiamos el mazo y los intentos de la sesión para que no se duplique al recargar (F5)
    //    y para que si vuelve a jugar tenga partida nueva
    unset($_SESSION['mazo']);
    unset($_SESSION['intentos']);

    // 3. Obtenemos la lista actualizada de jugadores
    $jugadores = obtenerJugadores();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartas - Resultado</title>
</head>
<body>
    <h1>¡Bienvenid@, <?=$_SESSION['nom_usuario']?>!</h1>
    <h2><?= $mensajeResultado; ?></h2>
    <p><?= $mensajeDetalle; ?></p>

    <h3>Puntos por jugador</h3>
    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Puntos</th>
                <th>Extra</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($jugadores); $i++) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($jugadores[$i]['nombre']) . "</td>";
                echo "<td>" . $jugadores[$i]['puntos'] . "</td>";
                echo "<td>" . $jugadores[$i]['extra'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="mostrarcartas.php">Volver a jugar</a> | <a href="index.php">Cerrar sesión</a>
</body>
</html>