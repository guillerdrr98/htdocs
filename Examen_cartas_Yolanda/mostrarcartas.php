<?php
// ==========================================================
// EJERCICIO 1 - JUEGO DE CARTAS (mostrarcartas.php)
// ==========================================================
session_start();
require_once('conexion.php');

// Si no hay usuario logueado, volvemos a la entrada
if (!isset($_SESSION['login'])) {
    header("Location: entrada.php");
    exit();
}

// ----------------------------------------------------------
// a) Mensaje de bienvenida: buscamos el nombre del jugador
// ----------------------------------------------------------
$stmt = $conn->prepare("SELECT nombre FROM jugador WHERE login = ?");
$stmt->bind_param("s", $_SESSION['login']);
$stmt->execute();
$fila = $stmt->get_result()->fetch_assoc();
$_SESSION['nombre'] = $fila['nombre'];
$conn->close();

// ----------------------------------------------------------
// d) Al empezar la jugada (sin pulsar ningún botón) se genera
//    una combinación aleatoria de 6 cartas en parejas de 2.
//    Se guarda en la sesión para que no se pierda.
// ----------------------------------------------------------
if (!isset($_POST['carta'])) {
    $cartas = ["copas_02.jpg", "copas_02.jpg",
               "copas_03.jpg", "copas_03.jpg",
               "copas_05.jpg", "copas_05.jpg"];
    shuffle($cartas);                 // mezclamos las 6 cartas

    $_SESSION['cartas'] = $cartas;    // la combinación se recuerda en toda la jugada
    $_SESSION['levantadas'] = 0;      // cartas levantadas a 0
}

// ----------------------------------------------------------
// f) Al pulsar un botón "Levantar carta" guardamos su posición
//    y sumamos 1 a las cartas levantadas.
//    La combinación NO se vuelve a generar.
// ----------------------------------------------------------
$cartaLevantada = 0;   // 0 = ninguna carta levantada (todas boca abajo)

if (isset($_POST['carta'])) {
    $cartaLevantada = $_POST['carta'];
    $_SESSION['levantadas']++;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juego de cartas</title>
</head>
<body>
    <!-- a) Bienvenida al usuario -->
    <h1>Bienvenid@, <?php echo $_SESSION['nombre']; ?></h1>

    <h1>Cartas levantadas:
        <input type="text" value="<?php echo $_SESSION['levantadas']; ?>" readonly>
    </h1>

    <!-- b) Formulario dinámico: los 6 botones se generan con un bucle -->
    <form method="post" action="mostrarcartas.php">
        <?php
        for ($i = 1; $i <= 6; $i++) {
            echo "<button type='submit' name='carta' value='$i'>Levantar carta $i</button> ";
        }
        ?>
    </form>

    <!-- c) Cajas de pareja (valores entre 1 y 6) y botón Comprobar -->
    <form method="post" action="resultado.php">
        <h1>Pareja:
            <input type="number" name="pos1" min="1" max="6" required>
            <input type="number" name="pos2" min="1" max="6" required>
            <input type="submit" value="Comprobar">
        </h1>
    </form>

    <?php
    // ------------------------------------------------------
    // e) y f) Pintamos las 6 cartas: todas boca abajo excepto
    //         la del botón pulsado, que se muestra volteada
    // ------------------------------------------------------
    for ($i = 1; $i <= 6; $i++) {
        if ($i == $cartaLevantada) {
            $imagen = $_SESSION['cartas'][$i - 1];   // el array empieza en 0
        } else {
            $imagen = "boca_abajo.jpg";
        }
        echo "<img src='$imagen' width='100' height='150'> ";
    }
    ?>
</body>
</html>
